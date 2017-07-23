<?php

namespace API\Controller\View;

use API\Controller\View\ViewEntity\MaintenanceType;
use Zend\View\Model\JsonModel;
use Core\Entity\MaintenanceType as MaintenanceTypeEntity;

class MaintenanceTypeModel extends JsonModel
{
    /**
     * @param MaintenanceTypeEntity $mark
     */
    public function __construct($mark)
    {
        parent::__construct(MaintenanceType::generateEntity($mark));
    }
}
