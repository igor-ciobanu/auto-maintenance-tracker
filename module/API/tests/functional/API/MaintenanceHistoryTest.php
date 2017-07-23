<?php
/**
 * Created by PhpStorm.
 * User: iciobanu
 * Date: 10/29/15
 * Time: 10:22 AM
 */

namespace functional\API;

use API\Helper\Url;
use Core\Entity\Repository\Car;
use Core\Entity\Repository\MaintenanceRule;
use Core\Entity\Repository\Mark;
use Core\Entity\Repository\MaintenanceHistory;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class MaintenanceHistoryTest extends AbstractHttpControllerTestCase
{
    const TEST_MAINTENANCE_HISTORY = '111222';

    /** @var MaintenanceHistory */
    private $maintenanceHistoryRepo;
    /** @var EntityManager */
    private $entityManager;
    /** @var Car */
    private $carRepo;
    /** @var MaintenanceRule */
    private $maintenanceRuleRepo;

    public function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        $this->sm = \TestBootstrap::app()->getServiceManager();
        /** @var EntityManager entityManager */
        $this->entityManager = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->maintenanceHistoryRepo = $this->entityManager->getRepository(\Core\Entity\MaintenanceHistory::class);
        $this->carRepo = $this->entityManager->getRepository(\Core\Entity\Car::class);
        $this->maintenanceRuleRepo = $this->entityManager->getRepository(\Core\Entity\MaintenanceRule::class);
        parent::setUp();
    }

    private function cleanTestMaintenanceHistories()
    {
        $maintenanceHistories = $this->maintenanceHistoryRepo->findBy([
            'km' => self::TEST_MAINTENANCE_HISTORY,
        ]);
        foreach ($maintenanceHistories as $maintenanceHistory) {
            $this->entityManager->remove($maintenanceHistory);
        }
    }

    /**
     * @test
     */
    public function testFetchMaintenanceHistory()
    {
        $this->insertTestData();
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MAINTENANCE_HISTORY_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancehistory');
        $this->assertControllerClass('maintenancehistory');
        $this->assertMatchedRouteName('maintenancehistoryapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertTrue(count($response->_embedded->maintenanceHistories) > 0);
    }

    /**
     * @test
     */
    public function testCreateMaintenanceHistoryWithInvalidData()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'invalid' => self::TEST_MAINTENANCE_HISTORY,
            ]));
        $this->dispatch(Url::API_MAINTENANCE_HISTORY_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancehistory');
        $this->assertControllerClass('maintenancehistory');
        $this->assertMatchedRouteName('maintenancehistoryapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals("KM Name: Value is required and can't be empty", $response->message[0]);
    }

    /**
     * @test
     */
    public function testCreateMaintenanceHistoryWithValidData()
    {
        $this->cleanTestMaintenanceHistories();
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'km' => self::TEST_MAINTENANCE_HISTORY,
                'car_id' => 1,
                'maintenance_rule_id' => 1,
            ]));
        $this->dispatch(Url::API_MAINTENANCE_HISTORY_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancehistory');
        $this->assertControllerClass('maintenancehistory');
        $this->assertMatchedRouteName('maintenancehistoryapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals(self::TEST_MAINTENANCE_HISTORY, $response->km);

        $car = $this->fetchCarById(1);
        $this->assertEquals(self::TEST_MAINTENANCE_HISTORY, $car->km);
    }

    /**
     * @test
     */
    public function testUpdateMaintenanceHistory()
    {
        $this->cleanTestMaintenanceHistories();
        $entity = $this->insertTestData();

        $this->dispatch(Url::API_MAINTENANCE_HISTORY_URL . '/' . $entity->getId(), 'PUT', [
            'km' => self::TEST_MAINTENANCE_HISTORY . '9',
            'car_id' => 1,
            'maintenance_rule_id' => 2,
        ]);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancehistory');
        $this->assertControllerClass('maintenancehistory');
        $this->assertMatchedRouteName('maintenancehistoryapi');
        $this->assertNull(null);

        $response = $this->fetchEntity($entity);
        $this->assertEquals(self::TEST_MAINTENANCE_HISTORY . '9', $response->km);

        $car = $this->fetchCarById(1);
        $this->assertEquals(self::TEST_MAINTENANCE_HISTORY . '9', $car->km);
    }

    /**
     *
     */
    public function testDeleteMaintenanceHistory()
    {
        $entity = $this->maintenanceHistoryRepo->findOneBy([
            'km' => self::TEST_MAINTENANCE_HISTORY . '9',
        ]);
        $this->dispatch(Url::API_MAINTENANCE_HISTORY_URL . '/' . $entity->getId(), 'DELETE');
        $response = $this->fetchEntity($entity);
        $this->assertEquals('API error. MaintenanceHistory doesn\'t exist', $response->message);
    }

    /**
     * @param \Core\Entity\MaintenanceHistory $entity
     * @return mixed
     */
    private function fetchEntity($entity)
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MAINTENANCE_HISTORY_URL . '/' . $entity->getId());
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\maintenancehistory');
        $this->assertControllerClass('maintenancehistory');
        $this->assertMatchedRouteName('maintenancehistoryapi');
        $response = Json::decode($this->getResponse()->getContent());
        return $response;
    }

    /**
     * @param $carId
     * @return mixed
     */
    private function fetchCarById($carId)
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_CAR_URL . '/' . $carId);
        $response = Json::decode($this->getResponse()->getContent());
        return $response;
    }

    private function getCarTest()
    {
        return $this->carRepo->find(1);
    }

    private function getMaintenanceRuleTest()
    {
        return $this->maintenanceRuleRepo->find(1);
    }

    /**
     * @return \Core\Entity\MaintenanceHistory
     */
    private function insertTestData()
    {
        $entity = new \Core\Entity\MaintenanceHistory();
        $entity->setKm(self::TEST_MAINTENANCE_HISTORY);
        $entity->setCar($this->getCarTest());
        $entity->setMaintenanceRule($this->getMaintenanceRuleTest());
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }
}
