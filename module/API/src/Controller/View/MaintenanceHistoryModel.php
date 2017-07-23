<?php

namespace API\Controller\View;

use API\Controller\View\ViewEntity\MaintenanceHistory;
use Zend\View\Model\JsonModel;
use Core\Entity\MaintenanceHistory as MaintenanceHistoryEntity;

class MaintenanceHistoryModel extends JsonModel
{
    /**
     * @param MaintenanceHistoryEntity $mark
     */
    public function __construct($mark)
    {
        parent::__construct(MaintenanceHistory::generateEntity($mark));
    }
}
