<?php

namespace API\Service;

use API\Exception\MaintenanceRuleDoesNotExistException;
use API\Exception\MaintenanceRuleValidationException;
use API\RequestModel\MaintenanceRule as MaintenanceRuleRequestMaintenanceRule;
use API\Service\SqlSpec\MaintenanceRuleListFilter;
use API\Service\Validator\MaintenanceRule as MaintenanceRuleValidator;
use Core\Entity\MaintenanceRule as MaintenanceRuleEntity;
use Core\Entity\Repository\MaintenanceRule as MaintenanceRuleRepo;
use Core\Entity\Repository\MaintenanceType as MaintenanceTypeRepo;
use Core\Entity\Repository\CarType as CarTypeRepo;
use Doctrine\ORM\EntityManager;

class MaintenanceRule
{
    /** @var MaintenanceRuleValidator  */
    private $modelValidator;
    /** @var EntityManager  */
    private $entityManager;


    public function __construct(
        EntityManager $entityManager,
        MaintenanceRuleValidator $modelValidator
    ) {
        $this->entityManager = $entityManager;
        $this->modelValidator = $modelValidator;
    }


    public function getList(MaintenanceRuleRequestMaintenanceRule $requestMaintenanceRule)
    {
        return $this->getMaintenanceRuleRepo()
            ->findFromSpecification(new MaintenanceRuleListFilter($requestMaintenanceRule));
    }

    public function get($id)
    {
        return $this->getEntity($id);
    }

    public function create(MaintenanceRuleRequestMaintenanceRule $modelRequest)
    {
        $this->validate($modelRequest);
        /** @var MaintenanceRuleEntity $modelEntity */
        $modelEntity = new MaintenanceRuleEntity();
        $modelEntity->setKm($modelRequest->km);
        $this->setCarType($modelRequest, $modelEntity);
        $this->setMaintenanceType($modelRequest, $modelEntity);
        $this->entityManager->persist($modelEntity);
        $this->entityManager->flush();
        return $modelEntity;
    }

    public function update(MaintenanceRuleRequestMaintenanceRule $modelRequest)
    {
        /** @var MaintenanceRuleEntity $country */
        $modelEntity = $this->getEntity($modelRequest->id);
        $this->validate($modelRequest);
        if ($modelRequest->km) {
            $modelEntity->setKm($modelRequest->km);
        }
        if ($modelRequest->car_type_id) {
            $this->setCarType($modelRequest, $modelEntity);
        }
        if ($modelRequest->maintenance_type_id) {
            $this->setMaintenanceType($modelRequest, $modelEntity);
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
     * @param MaintenanceRuleRequestMaintenanceRule $modelRequest
     * @throws MaintenanceRuleValidationException
     */
    private function validate(MaintenanceRuleRequestMaintenanceRule $modelRequest)
    {
        $this->modelValidator->validate($modelRequest);
        if ($this->modelValidator->hasErrors()) {
            throw new MaintenanceRuleValidationException($this->modelValidator->getErrorJson());
        }
    }

    /**
     * @param $id
     * @return MaintenanceRuleEntity
     * @throws MaintenanceRuleDoesNotExistException
     */
    private function getEntity($id)
    {
        /** @var MaintenanceRuleEntity $modelEntity */
        $modelEntity = $this->getMaintenanceRuleRepo()->find($id);
        if (empty($modelEntity)) {
            throw new MaintenanceRuleDoesNotExistException("MaintenanceRule doesn't exist");
        }
        return $modelEntity;
    }

    /**
     * @param MaintenanceRuleRequestMaintenanceRule $modelRequest
     * @param MaintenanceRuleEntity $modelEntity
     * @throws MaintenanceRuleValidationException
     */
    private function setCarType(MaintenanceRuleRequestMaintenanceRule $modelRequest, $modelEntity)
    {
        $carType = $this->getCarTypeRepo()->find($modelRequest->car_type_id);
        if (! $carType) {
            throw new MaintenanceRuleValidationException("Car Type not found");
        }
        $modelEntity->setCarType($carType);
    }

    /**
     * @param MaintenanceRuleRequestMaintenanceRule $modelRequest
     * @param MaintenanceRuleEntity $modelEntity
     * @throws MaintenanceRuleValidationException
     */
    private function setMaintenanceType(MaintenanceRuleRequestMaintenanceRule $modelRequest, $modelEntity)
    {
        $maintenanceType = $this->getMaintenanceTypeRepo()->find($modelRequest->maintenance_type_id);
        if (! $maintenanceType) {
            throw new MaintenanceRuleValidationException("Maintenance Type not found");
        }
        $modelEntity->setMaintenanceType($maintenanceType);
    }

    /**
     * @return CarTypeRepo
     */
    private function getCarTypeRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\CarType::class);
    }

    /**
     * @return MaintenanceTypeRepo
     */
    private function getMaintenanceTypeRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\MaintenanceType::class);
    }

    /**
     * @return MaintenanceRuleRepo
     */
    private function getMaintenanceRuleRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\MaintenanceRule::class);
    }
}
