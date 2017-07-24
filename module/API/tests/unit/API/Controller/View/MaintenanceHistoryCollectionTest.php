<?php

namespace unit\API\Controller\View;

use PHPUnit\Framework\TestCase;

class MaintenanceHistoryCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\MaintenanceHistory();
        $entity->setKm('123');
        $workflowModel = new \API\Controller\View\MaintenanceHistoryCollection([$entity]);
        $this->assertEquals(1, count($workflowModel->getVariable('_embedded')['maintenanceHistories']));
    }
}
