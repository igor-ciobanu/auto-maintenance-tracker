<?php

namespace unit\API\Controller\View;

use PHPUnit\Framework\TestCase;

class ModelCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\Model();
        $entity->setName('test');
        $workflowModel = new \API\Controller\View\ModelCollection([$entity]);
        $this->assertEquals(1, count($workflowModel->getVariable('_embedded')['models']));
    }
}
