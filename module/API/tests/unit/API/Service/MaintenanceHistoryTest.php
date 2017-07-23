<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 1:07 PM
 */

namespace unit\API\Service;

use API\RequestModel\MaintenanceHistory;
use PHPUnit\Framework\TestCase;

class MaintenanceHistoryTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
        $result = $service->getList(new MaintenanceHistory([]));
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
        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
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
        $repoMock->method('find')->willReturn(new \Core\Entity\MaintenanceHistory());
        $em->method('getRepository')->willReturn($repoMock);

        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
        $result = $service->get(1);
        $this->assertTrue($result instanceof \Core\Entity\MaintenanceHistory);
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testDeleteNotFound()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
        $service->delete(1);
    }

    /**
     * @test
     */
    public function testDeleteSuccess()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\MaintenanceHistory());
        $em->method('getRepository')->willReturn($repoMock);
        $em->expects($this->once())->method('remove');
        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
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
        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
        $service->update(new MaintenanceHistory([]));
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
                new \Core\Entity\MaintenanceHistory(),
                new \Core\Entity\Car(),
                new \Core\Entity\MaintenanceRule()
            )
        );
        $em->expects($this->exactly(2))->method('persist');
        $em->expects($this->exactly(2))->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
        $service->update(new MaintenanceHistory([
            'id' => 1,
            'maintenance_rule_id' => 1,
            'car_id' => 1,
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
        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
        $service->create(new MaintenanceHistory([]));
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
                new \Core\Entity\Car(),
                new \Core\Entity\MaintenanceRule()
            )
        );
        $em->expects($this->exactly(2))->method('persist');
        $em->expects($this->exactly(2))->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\MaintenanceHistory($em, new \API\Service\Validator\MaintenanceHistory());
        $result = $service->create(new MaintenanceHistory([
            'id' => 1,
            'maintenance_rule_id' => 1,
            'car_id' => 1,
            'km' => '123',
        ]));
        $this->assertTrue($result instanceof \Core\Entity\MaintenanceHistory);
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
        $repo = $this->getMockBuilder('Core\Entity\Repository\MaintenanceHistory')
            ->disableOriginalConstructor()->getMock();
        $repo->method('findFromSpecification')->willReturn([new \Core\Entity\MaintenanceHistory()]);
        return $repo;
    }
}
