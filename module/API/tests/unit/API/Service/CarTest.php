<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 1:07 PM
 */

namespace unit\API\Service;

use API\RequestModel\Car;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
        $result = $service->getList(new Car([]));
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
        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
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
        $repoMock->method('find')->willReturn(new \Core\Entity\Car());
        $em->method('getRepository')->willReturn($repoMock);

        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
        $result = $service->get(1);
        $this->assertTrue($result instanceof \API\ResponseModel\Car);
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testDeleteNotFound()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
        $service->delete(1);
    }

    /**
     * @test
     */
    public function testDeleteSuccess()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\Car());
        $em->method('getRepository')->willReturn($repoMock);
        $em->expects($this->once())->method('remove');
        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
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
        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
        $service->update(new Car([]));
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
                new \Core\Entity\Car(),
                new \Core\Entity\CarType(),
                new \Core\Entity\Model()
            )
        );
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
        $service->update(new Car([
            'id' => 1,
            'model_id' => 1,
            'car_type_id' => 1,
            'vin' => '123sd',
            'year' => 1990,
            'km' => '123',
        ]));
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function tesCreateInvalid()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
        $service->create(new Car([]));
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
                new \Core\Entity\CarType(),
                new \Core\Entity\Model()
            )
        );
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\Car($em, new \API\Service\Validator\Car());
        $result = $service->create(new Car([
            'id' => 1,
            'model_id' => 1,
            'car_type_id' => 1,
            'vin' => '123sd',
            'year' => 1990,
            'km' => '123',
        ]));
        $this->assertTrue($result instanceof \API\ResponseModel\Car);
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
        $repo = $this->getMockBuilder('Core\Entity\Repository\Car')
            ->disableOriginalConstructor()->getMock();
        $repo->method('findFromSpecification')->willReturn([new \Core\Entity\Car()]);
        return $repo;
    }
}
