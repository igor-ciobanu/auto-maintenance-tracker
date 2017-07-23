<?php

namespace API\Service;

use API\Exception\MaintenanceTypeDoesNotExistException;
use API\Exception\MaintenanceTypeValidationException;
use API\RequestModel\MaintenanceType as MaintenanceTypeRequestModel;
use API\Service\SqlSpec\MaintenanceTypeListFilter;
use API\Service\Validator\MaintenanceType as MaintenanceTypeValidator;
use Core\Entity\MaintenanceType as MaintenanceTypeEntity;
use Core\Entity\Repository\MaintenanceType as MaintenanceTypeRepo;
use Doctrine\ORM\EntityManager;

class MaintenanceType
{
    /** @var MaintenanceTypeValidator  */
    private $maintenanceTypeValidator;
    /** @var EntityManager  */
    private $entityManager;


    public function __construct(
        EntityManager $entityManager,
        MaintenanceTypeValidator $maintenanceTypeValidator
    ) {
        $this->entityManager = $entityManager;
        $this->maintenanceTypeValidator = $maintenanceTypeValidator;
    }


    public function getList(MaintenanceTypeRequestModel $requestModel)
    {
        return $this->getMaintenanceTypeRepo()->findFromSpecification(new MaintenanceTypeListFilter($requestModel));
    }

    public function get($id)
    {
        return $this->getEntity($id);
    }

    public function create(MaintenanceTypeRequestModel $maintenanceTypeRequest)
    {
        $this->validate($maintenanceTypeRequest);
        /** @var MaintenanceTypeEntity $maintenanceTypeEntity */
        $maintenanceTypeEntity = new MaintenanceTypeEntity();
        $maintenanceTypeEntity->setName($maintenanceTypeRequest->name);
        $this->entityManager->persist($maintenanceTypeEntity);
        $this->entityManager->flush();
        return $maintenanceTypeEntity;
    }

    public function update(MaintenanceTypeRequestModel $maintenanceTypeRequest)
    {
        /** @var MaintenanceTypeEntity $country */
        $maintenanceTypeEntity = $this->getEntity($maintenanceTypeRequest->id);
        $this->validate($maintenanceTypeRequest);
        $maintenanceTypeEntity->setName($maintenanceTypeRequest->name);
        $this->entityManager->persist($maintenanceTypeEntity);
        $this->entityManager->flush();
    }

    public function delete($id)
    {
        $maintenanceTypeEntity = $this->getEntity($id);
        $this->entityManager->remove($maintenanceTypeEntity);
        $this->entityManager->flush();
    }

    /**
     * @param MaintenanceTypeRequestModel $maintenanceTypeRequest
     * @throws MaintenanceTypeValidationException
     */
    private function validate(MaintenanceTypeRequestModel $maintenanceTypeRequest)
    {
        $this->maintenanceTypeValidator->validate($maintenanceTypeRequest);
        if ($this->maintenanceTypeValidator->hasErrors()) {
            throw new MaintenanceTypeValidationException($this->maintenanceTypeValidator->getErrorJson());
        }
    }

    /**
     * @param $id
     * @return MaintenanceTypeEntity
     * @throws MaintenanceTypeDoesNotExistException
     */
    private function getEntity($id)
    {
        /** @var MaintenanceTypeEntity $maintenanceTypeEntity */
        $maintenanceTypeEntity = $this->getMaintenanceTypeRepo()->find($id);
        if (empty($maintenanceTypeEntity)) {
            throw new MaintenanceTypeDoesNotExistException("MaintenanceType doesn't exist");
        }
        return $maintenanceTypeEntity;
    }

    /**
     * @return MaintenanceTypeRepo
     */
    private function getMaintenanceTypeRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\MaintenanceType::class);
    }
}
