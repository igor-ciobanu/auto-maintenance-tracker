<?php
/**
 * Created by PhpStorm.
 * User: iciobanu
 * Date: 10/29/15
 * Time: 10:22 AM
 */

namespace functional\API;

use API\Helper\Url;
use Core\Entity\Repository\MaintenanceType;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class MaintenanceTypeTest extends AbstractHttpControllerTestCase
{
    const TEST_MAINTENANCE_TYPE = '___test_maintenanceType';

    /** @var MaintenanceType */
    private $maintenanceTypeRepo;
    /** @var  EntityManager */
    private $entityManager;

    public function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        $this->sm = \TestBootstrap::app()->getServiceManager();
        /** @var EntityManager entityManager */
        $this->entityManager = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->maintenanceTypeRepo = $this->entityManager->getRepository(\Core\Entity\MaintenanceType::class);
        parent::setUp();
    }

    private function cleanTestMaintenanceTypes()
    {
        $maintenanceTypes = $this->maintenanceTypeRepo->findBy([
            'name' => self::TEST_MAINTENANCE_TYPE,
        ]);
        foreach ($maintenanceTypes as $maintenanceType) {
            $this->entityManager->remove($maintenanceType);
        }
    }

    /**
     * @test
     */
    public function testFetchMaintenanceType()
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MAINTENANCE_TYPE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancetype');
        $this->assertControllerClass('maintenanceType');
        $this->assertMatchedRouteName('maintenancetypeapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertTrue(count($response->_embedded->maintenanceTypes) > 0);
    }

    /**
     * @test
     */
    public function testCreateMaintenanceTypeWithInvalidData()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'invalid' => self::TEST_MAINTENANCE_TYPE,
            ]));
        $this->dispatch(Url::API_MAINTENANCE_TYPE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancetype');
        $this->assertControllerClass('maintenanceType');
        $this->assertMatchedRouteName('maintenancetypeapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals("MaintenanceType Name: Value is required and can't be empty", $response->message[0]);
    }

    /**
     * @test
     */
    public function testCreateMaintenanceTypeWithValidData()
    {
        $this->cleanTestMaintenanceTypes();
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'name' => self::TEST_MAINTENANCE_TYPE,
            ]));
        $this->dispatch(Url::API_MAINTENANCE_TYPE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancetype');
        $this->assertControllerClass('maintenanceType');
        $this->assertMatchedRouteName('maintenancetypeapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals(self::TEST_MAINTENANCE_TYPE, $response->name);
    }

    /**
     * @test
     */
    public function testUpdateMaintenanceType()
    {
        $this->cleanTestMaintenanceTypes();
        $entity = new \Core\Entity\MaintenanceType();
        $entity->setName(self::TEST_MAINTENANCE_TYPE);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->dispatch(Url::API_MAINTENANCE_TYPE_URL . '/' . $entity->getId(), 'PUT', [
            'name' => self::TEST_MAINTENANCE_TYPE . '_updated',
        ]);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancetype');
        $this->assertControllerClass('maintenanceType');
        $this->assertMatchedRouteName('maintenancetypeapi');
        $this->assertNull(null);


        $response = $this->fetchEntity($entity);
        $this->assertEquals(self::TEST_MAINTENANCE_TYPE . '_updated', $response->name);
    }

    /**
     *
     */
    public function testDeleteMaintenanceType()
    {
        $entity = $this->maintenanceTypeRepo->findOneBy([
            'name' => self::TEST_MAINTENANCE_TYPE . '_updated',
        ]);
        $this->dispatch(Url::API_MAINTENANCE_TYPE_URL . '/' . $entity->getId(), 'DELETE');
        $response = $this->fetchEntity($entity);
        $this->assertEquals('API error. MaintenanceType doesn\'t exist', $response->message);
    }

    /**
     * @param \Core\Entity\MaintenanceType $entity
     * @return mixed
     */
    private function fetchEntity($entity)
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MAINTENANCE_TYPE_URL . '/' . $entity->getId());
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancetype');
        $this->assertControllerClass('maintenanceType');
        $this->assertMatchedRouteName('maintenancetypeapi');
        $response = Json::decode($this->getResponse()->getContent());
        return $response;
    }
}
