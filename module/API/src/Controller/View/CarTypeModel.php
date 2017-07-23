<?php

namespace API\Controller\View;

use API\Controller\View\ViewEntity\CarType;
use Zend\View\Model\JsonModel;
use Core\Entity\CarType as CarTypeEntity;

class CarTypeModel extends JsonModel
{
    /**
     * @param CarTypeEntity $carType
     */
    public function __construct($carType)
    {
        parent::__construct(CarType::generateEntity($carType));
    }
}
