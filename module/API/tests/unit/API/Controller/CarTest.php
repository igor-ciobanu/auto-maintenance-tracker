<?php

namespace unit\API\Controller;

use API\Controller\Car;
use API\Controller\View\ErrorModel;
use API\Controller\View\CarCollection;
use API\Controller\View\CarModel;
use Core\Entity\MaintenanceRule;
use Core\Entity\Model;
use PHPUnit\Framework\TestCase;
use Core\Entity\Car as Entity;
use Zend\View\Model\JsonModel;

class CarTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('getList')->willReturn([]);
        $controller = new Car($serviceMock);
        $result = $controller->getList();
        $this->assertTrue($result instanceof CarCollection);
    }

    /**
     * @test
     */
    public function testFetchAllError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('getList')->will($this->throwException(new \Exception('error')));
        $controller = new Car($serviceMock);
        $result = $controller->getList();
        $this->assertTrue($result instanceof ErrorModel);
    }

    /**
     * @test
     */
    public function testGet()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('get')->willReturn($this->getTestEntity());
        $controller = new Car($serviceMock);
        $result = $controller->get(1);
        $this->assertTrue($result instanceof CarModel);
    }

    /**
     * @test
     */
    public function testGetError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('get')->will($this->throwException(new \Exception('error')));
        $controller = new Car($serviceMock);
        $result = $controller->get(1);
        $this->assertTrue($result instanceof ErrorModel);
    }

    /**
     * @test
     */
    public function testCreate()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('create')->willReturn($this->getTestEntity());
        $controller = new Car($serviceMock);
        $result = $controller->create([]);
        $this->assertTrue($result instanceof CarModel);
    }

    /**
     * @test
     */
    public function testCreateError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('create')->will($this->throwException(new \Exception('error')));
        $controller = new Car($serviceMock);
        $result = $controller->create([]);
        $this->assertTrue($result instanceof ErrorModel);
    }

    /**
     * @test
     */
    public function testUpdate()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('update')->willReturn($this->getTestEntity());
        $controller = new Car($serviceMock);
        $result = $controller->update(1, []);
        $this->assertTrue($result instanceof JsonModel);
    }

    /**
     * @test
     */
    public function testUpdateError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('update')->will($this->throwException(new \Exception('error')));
        $controller = new Car($serviceMock);
        $result = $controller->update(1, []);
        $this->assertTrue($result instanceof ErrorModel);
    }

    /**
     * @test
     */
    public function testDelete()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('delete')->willReturn(null);
        $controller = new Car($serviceMock);
        $result = $controller->delete(1);
        $this->assertTrue($result instanceof JsonModel);
    }

    /**
     * @test
     */
    public function testDeleteError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('delete')->will($this->throwException(new \Exception('error')));
        $controller = new Car($serviceMock);
        $result = $controller->delete(1);
        $this->assertTrue($result instanceof ErrorModel);
    }

    private function getServiceMock()
    {
        $mock = $this->getMockBuilder('API\Service\Car')
            ->disableOriginalConstructor()->getMock();
        return $mock;
    }

    /**
     * @return \API\ResponseModel\Car
     */
    private function getTestEntity()
    {
        $response = new \API\ResponseModel\Car();
        $entity = new Entity();
        $entity->setModel(new Model());
        $response->car = $entity;
        return $response;
    }
}
