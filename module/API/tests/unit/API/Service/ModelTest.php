<?php

namespace unit\API\Service;

use API\RequestModel\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
        $result = $service->getList(new Model([]));
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
        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
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
        $repoMock->method('find')->willReturn(new \Core\Entity\Model());
        $em->method('getRepository')->willReturn($repoMock);

        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
        $result = $service->get(1);
        $this->assertTrue($result instanceof \Core\Entity\Model);
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testDeleteNotFound()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
        $service->delete(1);
    }

    /**
     * @test
     */
    public function testDeleteSuccess()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\Model());
        $em->method('getRepository')->willReturn($repoMock);
        $em->expects($this->once())->method('remove');
        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
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
        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
        $service->update(new Model([]));
    }

    /**
     * @test
     */
    public function testUpdateValid()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->will(
            $this->onConsecutiveCalls(
                new \Core\Entity\Model(),
                new \Core\Entity\Mark()
            )
        );
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
        $service->update(new Model(['id' => 1, 'mark_id' => 1, 'name' => 'test']));
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function tesCreateInvalid()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
        $service->create(new Model([]));
    }

    /**
     * @test
     */
    public function testCreateValid()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->will(
            $this->onConsecutiveCalls(
                new \Core\Entity\Mark(),
                new \Core\Entity\Model()
            )
        );
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\Model($em, new \API\Service\Validator\Model());
        $result = $service->create(new Model([
            'name' => 'test',
            'mark_id' => 1,
        ]));
        $this->assertTrue($result instanceof \Core\Entity\Model);
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
        $repo = $this->getMockBuilder('Core\Entity\Repository\Model')
            ->disableOriginalConstructor()->getMock();
        $repo->method('findFromSpecification')->willReturn([new \Core\Entity\Model()]);
        return $repo;
    }
}
