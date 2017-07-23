<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 2:22 PM
 */

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
