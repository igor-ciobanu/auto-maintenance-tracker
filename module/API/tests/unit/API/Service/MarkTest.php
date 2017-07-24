<?php

namespace unit\API\Service;

use API\RequestModel\Mark;
use PHPUnit\Framework\TestCase;

class MarkTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
        $result = $service->getList(new Mark([]));
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
        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
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
        $repoMock->method('find')->willReturn(new \Core\Entity\Mark());
        $em->method('getRepository')->willReturn($repoMock);

        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
        $result = $service->get(1);
        $this->assertTrue($result instanceof \Core\Entity\Mark);
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testDeleteNotFound()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
        $service->delete(1);
    }

    /**
     * @test
     */
    public function testDeleteSuccess()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\Mark());
        $em->method('getRepository')->willReturn($repoMock);
        $em->expects($this->once())->method('remove');
        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
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
        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
        $service->update(new Mark([]));
    }

    /**
     * @test
     */
    public function testUpdateValid()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\Mark());
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
        $service->update(new Mark(['id' => 1, 'name' => 'test']));
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function tesCreateInvalid()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
        $service->create(new Mark([]));
    }

    /**
     * @test
     */
    public function testCreateValid()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\Mark());
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\Mark($em, new \API\Service\Validator\Mark());
        $result = $service->create(new Mark([
            'name' => 'test',
        ]));
        $this->assertTrue($result instanceof \Core\Entity\Mark);
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
        $repo = $this->getMockBuilder('Core\Entity\Repository\Mark')
            ->disableOriginalConstructor()->getMock();
        $repo->method('findFromSpecification')->willReturn([new \Core\Entity\Mark()]);
        return $repo;
    }
}
