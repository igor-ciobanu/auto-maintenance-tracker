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
use Core\Entity\Repository\Model;
use Core\Entity\Repository\Car;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CarTest extends AbstractHttpControllerTestCase
{
    const TEST_CAR = '_1';

    /** @var Car */
    private $carRepo;
    /** @var  Model */
    private $modelRepo;
    /** @var  EntityManager */
    private $entityManager;
    /** @var  CarType */
    private $carTypeRepo;

    public function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        $this->sm = \TestBootstrap::app()->getServiceManager();
        /** @var EntityManager entityManager */
        $this->entityManager = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->carRepo = $this->entityManager->getRepository(\Core\Entity\Car::class);
        $this->modelRepo = $this->entityManager->getRepository(\Core\Entity\Model::class);
        $this->carTypeRepo = $this->entityManager->getRepository(\Core\Entity\CarType::class);
        parent::setUp();
    }

    private function cleanTestCars()
    {
        $cars = $this->carRepo->findBy([
            'vin' => self::TEST_CAR,
        ]);
        foreach ($cars as $car) {
            $this->entityManager->remove($car);
        }
    }

    /**
     * @test
     */
    public function testFetchCar()
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_CAR_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\car');
        $this->assertControllerClass('car');
        $this->assertMatchedRouteName('carapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertTrue(count($response->_embedded->cars) > 0);
    }

    /**
     * @test
     */
    public function testCreateCarWithInvalidData()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'invalid' => self::TEST_CAR,
            ]));
        $this->dispatch(Url::API_CAR_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\car');
        $this->assertControllerClass('car');
        $this->assertMatchedRouteName('carapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals("Car VIN: Value is required and can't be empty", $response->message[0]);
    }

    /**
     * @test
     */
    public function testCreateCarWithValidData()
    {
        $this->cleanTestCars();
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'vin' => self::TEST_CAR,
                'year' => 2009,
                'km' => 123212,
                'model_id' => 1,
                'car_type_id' => 1,
            ]));
        $this->dispatch(Url::API_CAR_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\car');
        $this->assertControllerClass('car');
        $this->assertMatchedRouteName('carapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals(self::TEST_CAR, $response->vin);
    }

    /**
     * @test
     */
    public function testUpdateCar()
    {
        $this->cleanTestCars();
        $entity = new \Core\Entity\Car();
        $entity->setVin(self::TEST_CAR);
        $entity->setYear(2010);
        $entity->setKm(12312);
        $entity->setModel($this->getModelTest());
        $entity->setCarType($this->getCarTypeTest());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->dispatch(Url::API_CAR_URL . '/' . $entity->getId(), 'PUT', [
            'vin' => self::TEST_CAR . '_updated',
            'car_type_id' => 1,
            'model_id' => 1,
            'year' => 2011,
            'km' => 140000,
        ]);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\car');
        $this->assertControllerClass('car');
        $this->assertMatchedRouteName('carapi');
        $this->assertNull(null);


        $response = $this->fetchEntity($entity);
        $this->assertEquals(self::TEST_CAR . '_updated', $response->vin);
    }

    /**
     *
     */
    public function testDeleteCar()
    {
        $entity = $this->carRepo->findOneBy([
            'vin' => self::TEST_CAR . '_updated',
        ]);
        $this->dispatch(Url::API_CAR_URL . '/' . $entity->getId(), 'DELETE');
        $response = $this->fetchEntity($entity);
        $this->assertEquals('API error. Car doesn\'t exist', $response->message);
    }

    /**
     * @param \Core\Entity\Car $entity
     * @return mixed
     */
    private function fetchEntity($entity)
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_CAR_URL . '/' . $entity->getId());
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\car');
        $this->assertControllerClass('car');
        $this->assertMatchedRouteName('carapi');
        $response = Json::decode($this->getResponse()->getContent());
        return $response;
    }

    private function getModelTest()
    {
        return $this->modelRepo->find(1);
    }

    private function getCarTypeTest()
    {
        return $this->carTypeRepo->find(1);
    }
}
