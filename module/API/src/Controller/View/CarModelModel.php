<?php

namespace API\Controller\View;

use API\Controller\View\ViewEntity\Model;
use Zend\View\Model\JsonModel;
use Core\Entity\Model as ModelEntity;

class CarModelModel extends JsonModel
{
    /**
     * @param ModelEntity $model
     */
    public function __construct($model)
    {
        parent::__construct(Model::generateEntity($model));
    }
}
