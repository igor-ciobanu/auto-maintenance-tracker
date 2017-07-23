<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 2:22 PM
 */

namespace unit\API\Controller\View;

use API\Controller\View\MaintenanceRuleModel;
use PHPUnit\Framework\TestCase;

class MaintenanceRuleModelTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\MaintenanceRule();
        $entity->setKm('123');
        $workflowModel = new MaintenanceRuleModel($entity);
        $this->assertEquals($entity->getKm(), $workflowModel->getVariable('km'));
    }
}
