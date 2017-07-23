<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 2:22 PM
 */

namespace unit\API\Controller\View;

use API\Controller\View\CarModel;
use API\ResponseModel\Car;
use PHPUnit\Framework\TestCase;

class CarModelTest extends TestCase
{
    /**
     * @test
     */
    public function testView()
    {
        $entity = new \Core\Entity\Car();
        $entity->setVin('test');
        $responseItem = new Car();
        $responseItem->car = $entity;
        $workflowModel = new CarModel($responseItem);
        $this->assertEquals($entity->getVin(), $workflowModel->getVariable('vin'));
    }
}
