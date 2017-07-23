<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 2:22 PM
 */

namespace unit\API\Controller\View;

use API\ResponseModel\Car;
use PHPUnit\Framework\TestCase;

class CarCollectionTest extends TestCase
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
        $workflowModel = new \API\Controller\View\CarCollection([$responseItem]);
        $this->assertEquals(1, count($workflowModel->getVariable('_embedded')['cars']));
    }
}
