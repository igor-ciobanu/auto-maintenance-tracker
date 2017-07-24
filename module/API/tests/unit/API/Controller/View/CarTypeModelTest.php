<?php

namespace unit\API\Controller\View;

use API\Controller\View\CarTypeModel;
use PHPUnit\Framework\TestCase;

class CarTypeModelTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\CarType();
        $entity->setType('test');
        $workflowModel = new CarTypeModel($entity);
        $this->assertEquals($entity->getType(), $workflowModel->getVariable('type'));
    }
}
