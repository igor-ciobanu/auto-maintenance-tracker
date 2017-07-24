<?php

namespace unit\API\Controller\View;

use API\Controller\View\MaintenanceHistoryModel;
use PHPUnit\Framework\TestCase;

class MaintenanceHistoryModelTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\MaintenanceHistory();
        $entity->setKm('123');
        $workflowModel = new MaintenanceHistoryModel($entity);
        $this->assertEquals($entity->getKm(), $workflowModel->getVariable('km'));
    }
}
