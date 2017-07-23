<?php
/**
 * Created by PhpStorm.
 * User: iciobanu
 * Date: 12/2/14
 * Time: 10:20 AM
 */
namespace API\Service;

use API\Exception\CarDoesNotExistException;
use API\Exception\CarValidationException;
use API\RequestModel\Car as CarRequestModel;
use API\Service\SqlSpec\CarListFilter;
use API\Service\SqlSpec\LastCarMaintenance;
use API\Service\Validator\Car as CarValidator;
use Core\Entity\Car as CarEntity;
use Core\Entity\MaintenanceHistory;
use Core\Entity\MaintenanceRule;
use Doctrine\ORM\EntityManager;

class Car
{
    /** @var CarValidator  */
    private $carTypeValidator;
    /** @var EntityManager  */
    private $entityManager;

    public function __construct(
        EntityManager $entityManager,
        CarValidator $carTypeValidator
    ) {
        $this->entityManager = $entityManager;
        $this->carTypeValidator = $carTypeValidator;
    }

    /**
     * @param CarRequestModel $requestModel
     * @return array
     */
    public function getList(CarRequestModel $requestModel)
    {
        $response = [];
        $result = $this->getCarRepo()->findFromSpecification(new CarListFilter($requestModel));
        foreach ($result as $car) {
            $response[] = $this->fillEmbedded($car);
        }
        return $response;
    }

    public function get($id)
    {
        return $this->fillEmbedded($this->getEntity($id));
    }

    public function create(CarRequestModel $carTypeRequest)
    {
        $this->validate($carTypeRequest);
        /** @var CarEntity $carEntity */
        $carEntity = new CarEntity();
        $this->fillEntity($carTypeRequest, $carEntity);
        $this->entityManager->persist($carEntity);
        $this->entityManager->flush();
        return $this->fillEmbedded($carEntity);
    }

    public function update(CarRequestModel $carTypeRequest)
    {
        /** @var CarEntity $country */
        $carEntity = $this->getEntity($carTypeRequest->id);
        $this->validate($carTypeRequest);
        $this->fillEntity($carTypeRequest, $carEntity);
        $this->entityManager->persist($carEntity);
        $this->entityManager->flush();
    }

    public function delete($id)
    {
        $carEntity = $this->getEntity($id);
        $this->entityManager->remove($carEntity);
        $this->entityManager->flush();
    }

    /**
     * @param CarRequestModel $carTypeRequest
     * @throws CarValidationException
     */
    private function validate(CarRequestModel $carTypeRequest)
    {
        $this->carTypeValidator->validate($carTypeRequest);
        if ($this->carTypeValidator->hasErrors()) {
            throw new CarValidationException($this->carTypeValidator->getErrorJson());
        }
    }

    /**
     * @param $id
     * @return CarEntity
     * @throws CarDoesNotExistException
     */
    private function getEntity($id)
    {
        /** @var CarEntity $carEntity */
        $carEntity = $this->getCarRepo()->find($id);
        if (empty($carEntity)) {
            throw new CarDoesNotExistException("Car doesn't exist");
        }
        return $carEntity;
    }

    /**
     * @param CarRequestModel $carTypeRequest
     * @param CarEntity $carEntity
     */
    private function fillEntity(CarRequestModel $carTypeRequest, $carEntity)
    {
        $carEntity->setVin($carTypeRequest->vin);
        $carEntity->setKm($carTypeRequest->km);
        $carEntity->setYear($carTypeRequest->year);
        $carEntity->setYear($carTypeRequest->year);
        $this->setCarType($carTypeRequest, $carEntity);
        $this->setModel($carTypeRequest, $carEntity);
    }

    /**
     * @param CarRequestModel $carRequest
     * @param CarEntity $entity
     * @throws CarValidationException
     */
    private function setCarType(CarRequestModel $carRequest, $entity)
    {
        $carType = $this->getCarTypeRepo()->find($carRequest->car_type_id);
        if (! $carType) {
            throw new CarValidationException("Car Type not found");
        }
        $entity->setCarType($carType);
    }

    /**
     * @param CarRequestModel $carRequest
     * @param CarEntity $entity
     * @throws CarValidationException
     */
    private function setModel($carRequest, $entity)
    {
        $model = $this->getModelRepo()->find($carRequest->model_id);
        if (! $model) {
            throw new CarValidationException("Model not found");
        }
        $entity->setModel($model);
    }

    /**
     * @param CarEntity $car
     * @return \API\ResponseModel\Car
     */
    private function fillEmbedded(CarEntity $car)
    {
        $responseItem = new \API\ResponseModel\Car();
        $responseItem->car = $car;
        $responseItem->nextMaintenances = $this->getCarMaintenances($car);
        return $responseItem;
    }

    /**
     * @param CarEntity $car
     * @return array
     */
    private function getCarMaintenances(CarEntity $car)
    {
        $result = [];
        $carType = $car->getCarType();
        if (! $carType) {
            return $result;
        }
        /** @var MaintenanceRule $rule */
        foreach ($carType->getMaintenanceRules() as $rule) {
            $result[] = [
                'id' => $rule->getId(),
                'type' => $rule->getMaintenanceType()->getName(),
                'next_maintenance' => $this->calculateNextMaintenance($car, $rule)
            ];
        }
        return $result;
    }

    private function calculateNextMaintenance(CarEntity $car, MaintenanceRule $rule)
    {
        /** @var MaintenanceHistory $historyItem */
        $historyItem = $this->getMaintenanceHistoryRepo()
            ->findOneFromSpecification(new LastCarMaintenance($car->getId(), $rule->getId()));
        if ($historyItem) {
            return $historyItem->getKm() + $rule->getKm();
        }
        return $car->getKm() + $rule->getKm();
    }

    /**
     * @return \Core\Entity\Repository\Car
     */
    private function getCarRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\Car::class);
    }

    /**
     * @return \Core\Entity\Repository\CarType
     */
    private function getCarTypeRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\CarType::class);
    }

    /**
     * @return \Core\Entity\Repository\Model
     */
    private function getModelRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\Model::class);
    }

    /**
     * @return \Core\Entity\Repository\MaintenanceHistory
     */
    private function getMaintenanceHistoryRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\MaintenanceHistory::class);
    }
}
