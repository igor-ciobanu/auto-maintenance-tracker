<?php

namespace API\Service;

use API\Exception\MarkDoesNotExistException;
use API\Exception\MarkValidationException;
use API\RequestModel\Mark as MarkRequestModel;
use API\Service\SqlSpec\MarkListFilter;
use API\Service\Validator\Mark as MarkValidator;
use Core\Entity\Mark as MarkEntity;
use Core\Entity\Repository\Mark as MarkRepo;
use Doctrine\ORM\EntityManager;

class Mark
{
    /** @var MarkValidator  */
    private $markValidator;
    /** @var EntityManager  */
    private $entityManager;


    public function __construct(
        EntityManager $entityManager,
        MarkValidator $markValidator
    ) {
        $this->entityManager = $entityManager;
        $this->markValidator = $markValidator;
    }


    public function getList(MarkRequestModel $requestModel)
    {
        return $this->getMarkRepo()->findFromSpecification(new MarkListFilter($requestModel));
    }

    public function get($id)
    {
        return $this->getEntity($id);
    }

    public function create(MarkRequestModel $markRequest)
    {
        $this->validate($markRequest);
        /** @var MarkEntity $markEntity */
        $markEntity = new MarkEntity();
        $markEntity->setName($markRequest->name);
        $this->entityManager->persist($markEntity);
        $this->entityManager->flush();
        return $markEntity;
    }

    public function update(MarkRequestModel $markRequest)
    {
        /** @var MarkEntity $country */
        $markEntity = $this->getEntity($markRequest->id);
        $this->validate($markRequest);
        $markEntity->setName($markRequest->name);
        $this->entityManager->persist($markEntity);
        $this->entityManager->flush();
    }

    public function delete($id)
    {
        $markEntity = $this->getEntity($id);
        $this->entityManager->remove($markEntity);
        $this->entityManager->flush();
    }

    /**
     * @param MarkRequestModel $markRequest
     * @throws MarkValidationException
     */
    private function validate(MarkRequestModel $markRequest)
    {
        $this->markValidator->validate($markRequest);
        if ($this->markValidator->hasErrors()) {
            throw new MarkValidationException($this->markValidator->getErrorJson());
        }
    }

    /**
     * @param $id
     * @return MarkEntity
     * @throws MarkDoesNotExistException
     */
    private function getEntity($id)
    {
        /** @var MarkEntity $markEntity */
        $markEntity = $this->getMarkRepo()->find($id);
        if (empty($markEntity)) {
            throw new MarkDoesNotExistException("Mark doesn't exist");
        }
        return $markEntity;
    }

    /**
     * @return MarkRepo
     */
    private function getMarkRepo()
    {
        return $this->entityManager->getRepository(\Core\Entity\Mark::class);
    }
}
