<?php

namespace unit\API\Controller\View;

use API\Controller\View\MaintenanceTypeModel;
use PHPUnit\Framework\TestCase;

class MaintenanceTypeModelTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\MaintenanceType();
        $entity->setName('test');
        $workflowModel = new MaintenanceTypeModel($entity);
        $this->assertEquals($entity->getName(), $workflowModel->getVariable('name'));
    }
}
