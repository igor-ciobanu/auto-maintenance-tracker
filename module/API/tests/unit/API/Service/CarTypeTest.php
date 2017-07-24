<?php

namespace unit\API\Service;

use API\RequestModel\CarType;
use PHPUnit\Framework\TestCase;

class CarTypeTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $result = $service->getList(new CarType([]));
        $this->assertEquals(1, count($result));
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testOneNotFound()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $result = $service->get(1);
        $this->assertEmpty($result);
    }

    /**
     * @test
     */
    public function testOneValid()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\CarType());
        $em->method('getRepository')->willReturn($repoMock);

        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $result = $service->get(1);
        $this->assertTrue($result instanceof \Core\Entity\CarType);
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testDeleteNotFound()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $service->delete(1);
    }

    /**
     * @test
     */
    public function testDeleteSuccess()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\CarType());
        $em->method('getRepository')->willReturn($repoMock);
        $em->expects($this->once())->method('remove');
        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $service->delete(1);
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testUpdateNotFound()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $service->update(new CarType([]));
    }

    /**
     * @test
     */
    public function testUpdateValid()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\CarType());
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $service->update(new CarType(['id' => 1, 'type' => 'test']));
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function tesCreateInvalid()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $service->create(new CarType([]));
    }

    /**
     * @test
     */
    public function testCreateValid()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\CarType());
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\CarType($em, new \API\Service\Validator\CarType());
        $result = $service->create(new CarType([
            'type' => 'test',
        ]));
        $this->assertTrue($result instanceof \Core\Entity\CarType);
    }


    private function getEntityManager()
    {

        $mock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()->getMock();

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getRepo()
    {
        $repo = $this->getMockBuilder('Core\Entity\Repository\CarType')
            ->disableOriginalConstructor()->getMock();
        $repo->method('findFromSpecification')->willReturn([new \Core\Entity\CarType()]);
        return $repo;
    }
}
