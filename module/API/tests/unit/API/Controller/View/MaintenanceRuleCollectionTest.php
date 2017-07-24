<?php

namespace unit\API\Controller\View;

use PHPUnit\Framework\TestCase;

class MaintenanceRuleCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\MaintenanceRule();
        $entity->setKm('123');
        $workflowModel = new \API\Controller\View\MaintenanceRuleCollection([$entity]);
        $this->assertEquals(1, count($workflowModel->getVariable('_embedded')['maintenanceRules']));
    }
}
