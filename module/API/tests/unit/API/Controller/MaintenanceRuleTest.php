<?php

namespace unit\API\Controller;

use API\Controller\MaintenanceRule;
use API\Controller\View\ErrorModel;
use API\Controller\View\MaintenanceRuleCollection;
use API\Controller\View\MaintenanceRuleModel;
use Core\Entity\CarType;
use Core\Entity\MaintenanceType;
use PHPUnit\Framework\TestCase;
use Core\Entity\MaintenanceRule as Entity;
use Zend\View\Model\JsonModel;

class MaintenanceRuleTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('getList')->willReturn([]);
        $controller = new MaintenanceRule($serviceMock);
        $result = $controller->getList();
        $this->assertTrue($result instanceof MaintenanceRuleCollection);
    }

    /**
     * @test
     */
    public function testFetchAllError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('getList')->will($this->throwException(new \Exception('error')));
        $controller = new MaintenanceRule($serviceMock);
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
        $controller = new MaintenanceRule($serviceMock);
        $result = $controller->get(1);
        $this->assertTrue($result instanceof MaintenanceRuleModel);
    }

    /**
     * @test
     */
    public function testGetError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('get')->will($this->throwException(new \Exception('error')));
        $controller = new MaintenanceRule($serviceMock);
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
        $controller = new MaintenanceRule($serviceMock);
        $result = $controller->create([]);
        $this->assertTrue($result instanceof MaintenanceRuleModel);
    }

    /**
     * @test
     */
    public function testCreateError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('create')->will($this->throwException(new \Exception('error')));
        $controller = new MaintenanceRule($serviceMock);
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
        $controller = new MaintenanceRule($serviceMock);
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
        $controller = new MaintenanceRule($serviceMock);
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
        $controller = new MaintenanceRule($serviceMock);
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
        $controller = new MaintenanceRule($serviceMock);
        $result = $controller->delete(1);
        $this->assertTrue($result instanceof ErrorModel);
    }

    private function getServiceMock()
    {
        $mock = $this->getMockBuilder('API\Service\MaintenanceRule')
            ->disableOriginalConstructor()->getMock();
        return $mock;
    }

    /**
     * @return Entity
     */
    private function getTestEntity()
    {
        $entity = new Entity();
        $entity->setMaintenanceType(new MaintenanceType());
        $entity->setCarType(new CarType());
        return $entity;
    }
}
