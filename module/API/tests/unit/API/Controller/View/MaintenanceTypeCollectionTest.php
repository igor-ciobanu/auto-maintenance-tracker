<?php

namespace unit\API\Controller\View;

use PHPUnit\Framework\TestCase;

class MaintenanceTypeCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\MaintenanceType();
        $entity->setName('test');
        $workflowModel = new \API\Controller\View\MaintenanceTypeCollection([$entity]);
        $this->assertEquals(1, count($workflowModel->getVariable('_embedded')['maintenanceTypes']));
    }
}
