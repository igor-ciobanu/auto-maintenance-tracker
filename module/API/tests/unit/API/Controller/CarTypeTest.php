<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 12/06/17
 * Time: 7:44 PM
 */

namespace unit\API\Controller;

use API\Controller\CarType;
use API\Controller\View\ErrorModel;
use API\Controller\View\CarTypeCollection;
use API\Controller\View\CarTypeModel;
use PHPUnit\Framework\TestCase;
use Core\Entity\CarType as Entity;
use Zend\View\Model\JsonModel;

class CarTypeTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('getList')->willReturn([]);
        $controller = new CarType($serviceMock);
        $result = $controller->getList();
        $this->assertTrue($result instanceof CarTypeCollection);
    }

    /**
     * @test
     */
    public function testFetchAllError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('getList')->will($this->throwException(new \Exception('error')));
        $controller = new CarType($serviceMock);
        $result = $controller->getList();
        $this->assertTrue($result instanceof ErrorModel);
    }

    /**
     * @test
     */
    public function testGet()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('get')->willReturn(new Entity());
        $controller = new CarType($serviceMock);
        $result = $controller->get(1);
        $this->assertTrue($result instanceof CarTypeModel);
    }

    /**
     * @test
     */
    public function testGetError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('get')->will($this->throwException(new \Exception('error')));
        $controller = new CarType($serviceMock);
        $result = $controller->get(1);
        $this->assertTrue($result instanceof ErrorModel);
    }

    /**
     * @test
     */
    public function testCreate()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('create')->willReturn(new Entity());
        $controller = new CarType($serviceMock);
        $result = $controller->create([]);
        $this->assertTrue($result instanceof CarTypeModel);
    }

    /**
     * @test
     */
    public function testCreateError()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('create')->will($this->throwException(new \Exception('error')));
        $controller = new CarType($serviceMock);
        $result = $controller->create([]);
        $this->assertTrue($result instanceof ErrorModel);
    }

    /**
     * @test
     */
    public function testUpdate()
    {
        $serviceMock = $this->getServiceMock();
        $serviceMock->method('update')->willReturn(new Entity());
        $controller = new CarType($serviceMock);
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
        $controller = new CarType($serviceMock);
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
        $controller = new CarType($serviceMock);
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
        $controller = new CarType($serviceMock);
        $result = $controller->delete(1);
        $this->assertTrue($result instanceof ErrorModel);
    }

    private function getServiceMock()
    {
        $mock = $this->getMockBuilder('API\Service\CarType')
            ->disableOriginalConstructor()->getMock();
        return $mock;
    }
}
