<?php

namespace API\Controller\View;

use API\Controller\View\ViewEntity\MaintenanceRule;
use Zend\View\Model\JsonModel;
use Core\Entity\MaintenanceRule as MaintenanceRuleEntity;

class MaintenanceRuleModel extends JsonModel
{
    /**
     * @param MaintenanceRuleEntity $mark
     */
    public function __construct($mark)
    {
        parent::__construct(MaintenanceRule::generateEntity($mark));
    }
}
