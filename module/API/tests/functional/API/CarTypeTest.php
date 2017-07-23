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
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CarTypeTest extends AbstractHttpControllerTestCase
{
    const TEST_CAR_TYPE = '___test_carType';

    /** @var CarType */
    private $carTypeRepo;
    /** @var  EntityManager */
    private $entityManager;

    public function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        $this->sm = \TestBootstrap::app()->getServiceManager();
        /** @var EntityManager entityManager */
        $this->entityManager = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->carTypeRepo = $this->entityManager->getRepository(\Core\Entity\CarType::class);
        parent::setUp();
    }

    private function cleanTestCarTypes()
    {
        $carTypes = $this->carTypeRepo->findBy([
            'type' => self::TEST_CAR_TYPE,
        ]);
        foreach ($carTypes as $carType) {
            $this->entityManager->remove($carType);
        }
    }

    /**
     * @test
     */
    public function testFetchCarType()
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_CAR_TYPE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\cartype');
        $this->assertControllerClass('carType');
        $this->assertMatchedRouteName('cartypeapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertTrue(count($response->_embedded->carTypes) > 0);
    }

    /**
     * @test
     */
    public function testCreateCarTypeWithInvalidData()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'invalid' => self::TEST_CAR_TYPE,
            ]));
        $this->dispatch(Url::API_CAR_TYPE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\cartype');
        $this->assertControllerClass('carType');
        $this->assertMatchedRouteName('cartypeapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals("CarType Name: Value is required and can't be empty", $response->message[0]);
    }

    /**
     * @test
     */
    public function testCreateCarTypeWithValidData()
    {
        $this->cleanTestCarTypes();
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'type' => self::TEST_CAR_TYPE,
            ]));
        $this->dispatch(Url::API_CAR_TYPE_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\cartype');
        $this->assertControllerClass('carType');
        $this->assertMatchedRouteName('cartypeapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals(self::TEST_CAR_TYPE, $response->type);
    }

    /**
     * @test
     */
    public function testUpdateCarType()
    {
        $this->cleanTestCarTypes();
        $entity = new \Core\Entity\CarType();
        $entity->setType(self::TEST_CAR_TYPE);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->dispatch(Url::API_CAR_TYPE_URL . '/' . $entity->getId(), 'PUT', [
            'type' => self::TEST_CAR_TYPE . '_updated',
        ]);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\cartype');
        $this->assertControllerClass('carType');
        $this->assertMatchedRouteName('cartypeapi');
        $this->assertNull(null);


        $response = $this->fetchEntity($entity);
        $this->assertEquals(self::TEST_CAR_TYPE . '_updated', $response->type);
    }

    /**
     *
     */
    public function testDeleteCarType()
    {
        $entity = $this->carTypeRepo->findOneBy([
            'type' => self::TEST_CAR_TYPE . '_updated',
        ]);
        $this->dispatch(Url::API_CAR_TYPE_URL . '/' . $entity->getId(), 'DELETE');
        $response = $this->fetchEntity($entity);
        $this->assertEquals('API error. CarType doesn\'t exist', $response->message);
    }

    /**
     * @param \Core\Entity\CarType $entity
     * @return mixed
     */
    private function fetchEntity($entity)
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_CAR_TYPE_URL . '/' . $entity->getId());
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\cartype');
        $this->assertControllerClass('carType');
        $this->assertMatchedRouteName('cartypeapi');
        $response = Json::decode($this->getResponse()->getContent());
        return $response;
    }
}
