<?php
/**
 * Created by PhpStorm.
 * User: iciobanu
 * Date: 12/2/14
 * Time: 10:20 AM
 */
namespace API\Service;

use API\Exception\CarTypeDoesNotExistException;
use API\Exception\CarTypeValidationException;
use API\RequestModel\CarType as CarTypeRequestModel;
use API\Service\SqlSpec\CarTypeListFilter;
use API\Service\Validator\CarType as CarTypeValidator;
use Core\Entity\CarType as CarTypeEntity;
use Doctrine\ORM\EntityManager;

class CarType
{
    /** @var CarTypeValidator  */
    private $carTypeValidator;
    /** @var EntityManager  */
    private $entityManager;

    public function __construct(
        EntityManager $entityManager,
        CarTypeValidator $carTypeValidator
    ) {
        $this->entityManager = $entityManager;
        $this->carTypeValidator = $carTypeValidator;
    }


    public function getList(CarTypeRequestModel $requestModel)
    {
        return $this->getCarTypeRepo()->findFromSpecification(new CarTypeListFilter($requestModel));
    }

    public function get($id)
    {
        return $this->getEntity($id);
    }

    public function create(CarTypeRequestModel $carTypeRequest)
    {
        $this->validate($carTypeRequest);
        /** @var CarTypeEntity $carTypeEntity */
        $carTypeEntity = new CarTypeEntity();
        $carTypeEntity->setType($carTypeRequest->type);
        $this->entityManager->persist($carTypeEntity);
        $this->entityManager->flush();
        return $carTypeEntity;
    }

    public function update(CarTypeRequestModel $carTypeRequest)
    {
        /** @var CarTypeEntity $country */
        $carTypeEntity = $this->getEntity($carTypeRequest->id);
        $this->validate($carTypeRequest);
        $carTypeEntity->setType($carTypeRequest->type);
        $this->entityManager->persist($carTypeEntity);
        $this->entityManager->flush();
    }

    public function delete($id)
    {
        $carTypeEntity = $this->getEntity($id);
        $this->entityManager->remove($carTypeEntity);
        $this->entityManager->flush();
    }

    /**
     * @param CarTypeRequestModel $carTypeRequest
     * @throws CarTypeValidationException
     */
    private function validate(CarTypeRequestModel $carTypeRequest)
    {
        $this->carTypeValidator->validate($carTypeRequest);
        if ($this->carTypeValidator->hasErrors()) {
            throw new CarTypeValidationException($this->carTypeValidator->getErrorJson());
        }
    }

    /**
     * @param $id
     * @return CarTypeEntity
     * @throws CarTypeDoesNotExistException
     */
    private function getEntity($id)
    {
        /** @var CarTypeEntity $carTypeEntity */
        $carTypeEntity = $this->getCarTypeRepo()->find($id);
        if (empty($carTypeEntity)) {
            throw new CarTypeDoesNotExistException("CarType doesn't exist");
        }
        return $carTypeEntity;
    }

    /**
     * @return \Core\Entity\Repository\CarType
     */
    private function getCarTypeRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\CarType::class);
    }
}
