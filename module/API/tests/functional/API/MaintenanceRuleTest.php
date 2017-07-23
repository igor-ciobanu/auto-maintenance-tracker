<?php
/**
 * Created by PhpStorm.
 * User: iciobanu
 * Date: 10/29/15
 * Time: 10:22 AM
 */

namespace functional\API;

use API\Helper\Url;
use Core\Entity\Repository\CarType;
use Core\Entity\Repository\MaintenanceType;
use Core\Entity\Repository\Mark;
use Core\Entity\Repository\MaintenanceRule;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class MaintenanceRuleTest extends AbstractHttpControllerTestCase
{
    const TEST_MAINTENANCE_RULE = '111222';

    /** @var MaintenanceRule */
    private $maintenanceRuleRepo;
    /** @var EntityManager */
    private $entityManager;
    /** @var CarType */
    private $carTypeRepo;
    /** @var MaintenanceType */
    private $maintenanceTypeRepo;

    public function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        $this->sm = \TestBootstrap::app()->getServiceManager();
        /** @var EntityManager entityManager */
        $this->entityManager = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->maintenanceRuleRepo = $this->entityManager->getRepository(\Core\Entity\MaintenanceRule::class);
        $this->carTypeRepo = $this->entityManager->getRepository(\Core\Entity\CarType::class);
        $this->maintenanceTypeRepo = $this->entityManager->getRepository(\Core\Entity\MaintenanceType::class);
        parent::setUp();
    }

    private function cleanTestMaintenanceRules()
    {
        $maintenanceRules = $this->maintenanceRuleRepo->findBy([
            'km' => self::TEST_MAINTENANCE_RULE,
        ]);
        foreach ($maintenanceRules as $maintenanceRule) {
            $this->entityManager->remove($maintenanceRule);
        }
    }

    /**
     * @test
     */
    public function testFetchMaintenanceRule()
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MAINTENANCE_RULE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancerule');
        $this->assertControllerClass('maintenancerule');
        $this->assertMatchedRouteName('maintenanceruleapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertTrue(count($response->_embedded->maintenanceRules) > 0);
    }

    /**
     * @test
     */
    public function testCreateMaintenanceRuleWithInvalidData()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'invalid' => self::TEST_MAINTENANCE_RULE,
            ]));
        $this->dispatch(Url::API_MAINTENANCE_RULE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancerule');
        $this->assertControllerClass('maintenancerule');
        $this->assertMatchedRouteName('maintenanceruleapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals("KM Name: Value is required and can't be empty", $response->message[0]);
    }

    /**
     * @test
     */
    public function testCreateMaintenanceRuleWithValidData()
    {
        $this->cleanTestMaintenanceRules();
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'km' => self::TEST_MAINTENANCE_RULE,
                'car_type_id' => 1,
                'maintenance_type_id' => 1,
            ]));
        $this->dispatch(Url::API_MAINTENANCE_RULE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancerule');
        $this->assertControllerClass('maintenancerule');
        $this->assertMatchedRouteName('maintenanceruleapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals(self::TEST_MAINTENANCE_RULE, $response->km);
    }

    /**
     * @test
     */
    public function testUpdateMaintenanceRule()
    {
        $this->cleanTestMaintenanceRules();
        $entity = new \Core\Entity\MaintenanceRule();
        $entity->setKm(self::TEST_MAINTENANCE_RULE);
        $entity->setCarType($this->getCarTypeTest());
        $entity->setMaintenanceType($this->getMaintenanceTypeTest());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->dispatch(Url::API_MAINTENANCE_RULE_URL . '/' . $entity->getId(), 'PUT', [
            'km' => self::TEST_MAINTENANCE_RULE . '9',
            'car_type_id' => 2,
            'maintenance_type_id' => 2,
        ]);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancerule');
        $this->assertControllerClass('maintenancerule');
        $this->assertMatchedRouteName('maintenanceruleapi');
        $this->assertNull(null);


        $response = $this->fetchEntity($entity);
        $this->assertEquals(self::TEST_MAINTENANCE_RULE . '9', $response->km);
    }

    /**
     *
     */
    public function testDeleteMaintenanceRule()
    {
        $entity = $this->maintenanceRuleRepo->findOneBy([
            'km' => self::TEST_MAINTENANCE_RULE . '9',
        ]);
        $this->dispatch(Url::API_MAINTENANCE_RULE_URL . '/' . $entity->getId(), 'DELETE');
        $response = $this->fetchEntity($entity);
        $this->assertEquals('API error. MaintenanceRule doesn\'t exist', $response->message);
    }

    /**
     * @param \Core\Entity\MaintenanceRule $entity
     * @return mixed
     */
    private function fetchEntity($entity)
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MAINTENANCE_RULE_URL . '/' . $entity->getId());
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancerule');
        $this->assertControllerClass('maintenancerule');
        $this->assertMatchedRouteName('maintenanceruleapi');
        $response = Json::decode($this->getResponse()->getContent());
        return $response;
    }

    private function getCarTypeTest()
    {
        return $this->carTypeRepo->find(1);
    }

    private function getMaintenanceTypeTest()
    {
        return $this->maintenanceTypeRepo->find(1);
    }
}
