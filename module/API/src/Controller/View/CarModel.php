<?php

namespace API\Controller\View;

use API\Controller\View\ViewEntity\Car;
use Zend\View\Model\JsonModel;
use API\ResponseModel\Car as ResponseItem;

class CarModel extends JsonModel
{
    /**
     * @param ResponseItem $item
     */
    public function __construct($item)
    {
        parent::__construct(Car::generateEntity($item));
    }
}
