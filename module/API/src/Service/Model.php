<?php

namespace API\Service;

use API\Exception\ModelDoesNotExistException;
use API\Exception\ModelValidationException;
use API\RequestModel\Model as ModelRequestModel;
use API\Service\SqlSpec\ModelListFilter;
use API\Service\Validator\Model as ModelValidator;
use Core\Entity\Model as ModelEntity;
use Core\Entity\Repository\Model as ModelRepo;
use Core\Entity\Repository\Mark as MarkRepo;
use Doctrine\ORM\EntityManager;

class Model
{

    /** @var ModelValidator  */
    private $modelValidator;
    /** @var EntityManager  */
    private $entityManager;


    public function __construct(
        EntityManager $entityManager,
        ModelValidator $modelValidator
    ) {
        $this->entityManager = $entityManager;
        $this->modelValidator = $modelValidator;
    }


    public function getList(ModelRequestModel $requestModel)
    {
        return $this->getModelRepo()->findFromSpecification(new ModelListFilter($requestModel));
    }

    public function get($id)
    {
        return $this->getEntity($id);
    }

    public function create(ModelRequestModel $modelRequest)
    {
        $this->validate($modelRequest);
        /** @var ModelEntity $modelEntity */
        $modelEntity = new ModelEntity();
        $modelEntity->setName($modelRequest->name);
        $this->setMark($modelRequest, $modelEntity);
        $this->entityManager->persist($modelEntity);
        $this->entityManager->flush();
        return $modelEntity;
    }

    public function update(ModelRequestModel $modelRequest)
    {
        /** @var ModelEntity $country */
        $modelEntity = $this->getEntity($modelRequest->id);
        $this->validate($modelRequest);
        if ($modelRequest->name) {
            $modelEntity->setName($modelRequest->name);
        }
        if ($modelRequest->mark_id) {
            $this->setMark($modelRequest, $modelEntity);
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
     * @param ModelRequestModel $modelRequest
     * @throws ModelValidationException
     */
    private function validate(ModelRequestModel $modelRequest)
    {
        $this->modelValidator->validate($modelRequest);
        if ($this->modelValidator->hasErrors()) {
            throw new ModelValidationException($this->modelValidator->getErrorJson());
        }
    }

    /**
     * @param $id
     * @return ModelEntity
     * @throws ModelDoesNotExistException
     */
    private function getEntity($id)
    {
        /** @var ModelEntity $modelEntity */
        $modelEntity = $this->getModelRepo()->find($id);
        if (empty($modelEntity)) {
            throw new ModelDoesNotExistException("Model doesn't exist");
        }
        return $modelEntity;
    }

    /**
     * @param ModelRequestModel $modelRequest
     * @param ModelEntity $modelEntity
     * @throws ModelValidationException
     */
    private function setMark(ModelRequestModel $modelRequest, $modelEntity)
    {
        $mark = $this->getMarkRepo()->find($modelRequest->mark_id);
        if (! $mark) {
            throw new ModelValidationException("Mark not found");
        }
        $modelEntity->setMark($mark);
    }

    /**
     * @return ModelRepo
     */
    private function getModelRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\Model::class);
    }

    /**
     * @return MarkRepo
     */
    private function getMarkRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\Mark::class);
    }
}
