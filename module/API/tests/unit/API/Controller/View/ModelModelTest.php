<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 2:22 PM
 */

namespace unit\API\Controller\View;

use API\Controller\View\CarModelModel;
use PHPUnit\Framework\TestCase;

class ModelModelTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\Model();
        $entity->setName('test');
        $workflowModel = new CarModelModel($entity);
        $this->assertEquals($entity->getName(), $workflowModel->getVariable('name'));
    }
}
