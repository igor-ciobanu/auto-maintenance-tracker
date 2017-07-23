<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 2:22 PM
 */

namespace unit\API\Controller\View;

use API\Controller\View\MarkModel;
use PHPUnit\Framework\TestCase;

class MarkModelTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\Mark();
        $entity->setName('test');
        $workflowModel = new MarkModel($entity);
        $this->assertEquals($entity->getName(), $workflowModel->getVariable('name'));
    }
}
