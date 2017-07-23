<?php

namespace API\Service;

use API\Exception\MaintenanceHistoryDoesNotExistException;
use API\Exception\MaintenanceHistoryValidationException;
use API\RequestModel\MaintenanceHistory as MaintenanceHistoryRequest;
use API\Service\SqlSpec\MaintenanceHistoryListFilter;
use API\Service\Validator\MaintenanceHistory as MaintenanceHistoryValidator;
use Core\Entity\Car;
use Core\Entity\CarType;
use Core\Entity\MaintenanceHistory as MaintenanceHistoryEntity;
use Core\Entity\Repository\MaintenanceHistory as MaintenanceHistoryRepo;
use Core\Entity\Repository\MaintenanceRule as MaintenanceRuleRepo;
use Core\Entity\Repository\Car as CarRepo;
use Doctrine\ORM\EntityManager;

class MaintenanceHistory
{
    /** @var MaintenanceHistoryValidator  */
    private $modelValidator;
    /** @var EntityManager  */
    private $entityManager;


    public function __construct(
        EntityManager $entityManager,
        MaintenanceHistoryValidator $modelValidator
    ) {
        $this->entityManager = $entityManager;
        $this->modelValidator = $modelValidator;
    }


    public function getList(MaintenanceHistoryRequest $requestMaintenanceHistory)
    {
        return $this->getMaintenanceHistoryRepo()
            ->findFromSpecification(new MaintenanceHistoryListFilter($requestMaintenanceHistory));
    }

    public function get($id)
    {
        return $this->getEntity($id);
    }

    public function create(MaintenanceHistoryRequest $modelRequest)
    {
        $this->validate($modelRequest);
        /** @var MaintenanceHistoryEntity $modelEntity */
        $modelEntity = new MaintenanceHistoryEntity();
        $modelEntity->setKm($modelRequest->km);
        $this->setCar($modelRequest, $modelEntity);
        $this->setMaintenanceRule($modelRequest, $modelEntity);
        $this->entityManager->persist($modelEntity);
        $this->entityManager->flush();
        return $modelEntity;
    }

    public function update(MaintenanceHistoryRequest $modelRequest)
    {
        /** @var MaintenanceHistoryEntity $country */
        $modelEntity = $this->getEntity($modelRequest->id);
        $this->validate($modelRequest);
        if ($modelRequest->km) {
            $modelEntity->setKm($modelRequest->km);
        }
        if ($modelRequest->car_id) {
            $this->setCar($modelRequest, $modelEntity);
        }
        if ($modelRequest->maintenance_rule_id) {
            $this->setMaintenanceRule($modelRequest, $modelEntity);
        }
        $this->entityManager->persist($modelEntity);
        $this->entityManager->flush();
    }

    public function delete($id)
    {
        $modelEntity = $this->getEntity($id);
        $this->entityManager->remove($modelEntity);
        $this->entityManager->flush();
    }

    /**
     * @param MaintenanceHistoryRequest $modelRequest
     * @throws MaintenanceHistoryValidationException
     */
    private function validate(MaintenanceHistoryRequest $modelRequest)
    {
        $this->modelValidator->validate($modelRequest);
        if ($this->modelValidator->hasErrors()) {
            throw new MaintenanceHistoryValidationException($this->modelValidator->getErrorJson());
        }
    }

    /**
     * @param $id
     * @return MaintenanceHistoryEntity
     * @throws MaintenanceHistoryDoesNotExistException
     */
    private function getEntity($id)
    {
        /** @var MaintenanceHistoryEntity $modelEntity */
        $modelEntity = $this->getMaintenanceHistoryRepo()->find($id);
        if (empty($modelEntity)) {
            throw new MaintenanceHistoryDoesNotExistException("MaintenanceHistory doesn't exist");
        }
        return $modelEntity;
    }

    /**
     * @param MaintenanceHistoryRequest $modelRequest
     * @param MaintenanceHistoryEntity $modelEntity
     * @throws MaintenanceHistoryValidationException
     */
    private function setCar(MaintenanceHistoryRequest $modelRequest, $modelEntity)
    {
        /** @var Car $car */
        $car = $this->getCarRepo()->find($modelRequest->car_id);
        if (! $car) {
            throw new MaintenanceHistoryValidationException("Car Type not found");
        }
        $car->setKm($modelRequest->km);
        $this->entityManager->persist($car);
        $this->entityManager->flush();
        $modelEntity->setCar($car);
    }

    /**
     * @param MaintenanceHistoryRequest $modelRequest
     * @param MaintenanceHistoryEntity $modelEntity
     * @throws MaintenanceHistoryValidationException
     */
    private function setMaintenanceRule(MaintenanceHistoryRequest $modelRequest, $modelEntity)
    {
        $maintenanceRule = $this->getMaintenanceRuleRepo()->find($modelRequest->maintenance_rule_id);
        if (! $maintenanceRule) {
            throw new MaintenanceHistoryValidationException("Maintenance Type not found");
        }
        $modelEntity->setMaintenanceRule($maintenanceRule);
    }

    /**
     * @return CarRepo
     */
    private function getCarRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\Car::class);
    }

    /**
     * @return MaintenanceRuleRepo
     */
    private function getMaintenanceRuleRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\MaintenanceRule::class);
    }

    /**
     * @return MaintenanceHistoryRepo
     */
    private function getMaintenanceHistoryRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\MaintenanceHistory::class);
    }
}
