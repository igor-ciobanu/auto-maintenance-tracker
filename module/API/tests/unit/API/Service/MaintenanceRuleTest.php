<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09/06/17
 * Time: 1:07 PM
 */

namespace unit\API\Service;

use API\RequestModel\MaintenanceRule;
use PHPUnit\Framework\TestCase;

class MaintenanceRuleTest extends TestCase
{
    /**
     * @test
     */
    public function testFetchAll()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
        $result = $service->getList(new MaintenanceRule([]));
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
        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
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
        $repoMock->method('find')->willReturn(new \Core\Entity\MaintenanceRule());
        $em->method('getRepository')->willReturn($repoMock);

        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
        $result = $service->get(1);
        $this->assertTrue($result instanceof \Core\Entity\MaintenanceRule);
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testDeleteNotFound()
    {
        $em = $this->getEntityManager();
        $em->method('getRepository')->willReturn($this->getRepo());
        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
        $service->delete(1);
    }

    /**
     * @test
     */
    public function testDeleteSuccess()
    {
        $em = $this->getEntityManager();
        $repoMock = $this->getRepo();
        $repoMock->method('find')->willReturn(new \Core\Entity\MaintenanceRule());
        $em->method('getRepository')->willReturn($repoMock);
        $em->expects($this->once())->method('remove');
        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
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
        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
        $service->update(new MaintenanceRule([]));
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
                new \Core\Entity\MaintenanceRule(),
                new \Core\Entity\CarType(),
                new \Core\Entity\MaintenanceType()
            )
        );
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
        $service->update(new MaintenanceRule([
            'id' => 1,
            'maintenance_type_id' => 1,
            'car_type_id' => 1,
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
        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
        $service->create(new MaintenanceRule([]));
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
                new \Core\Entity\MaintenanceType()
            )
        );
        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');
        $em->method('getRepository')->willReturn($repoMock);
        $service = new \API\Service\MaintenanceRule($em, new \API\Service\Validator\MaintenanceRule());
        $result = $service->create(new MaintenanceRule([
            'id' => 1,
            'maintenance_type_id' => 1,
            'car_type_id' => 1,
            'km' => '123',
        ]));
        $this->assertTrue($result instanceof \Core\Entity\MaintenanceRule);
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
        $repo = $this->getMockBuilder('Core\Entity\Repository\MaintenanceRule')
            ->disableOriginalConstructor()->getMock();
        $repo->method('findFromSpecification')->willReturn([new \Core\Entity\MaintenanceRule()]);
        return $repo;
    }
}
