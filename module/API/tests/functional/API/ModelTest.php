<?php
/**
 * Created by PhpStorm.
 * User: iciobanu
 * Date: 10/29/15
 * Time: 10:22 AM
 */

namespace functional\API;

use API\Helper\Url;
use Core\Entity\Repository\Mark;
use Core\Entity\Repository\Model;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ModelTest extends AbstractHttpControllerTestCase
{
    const TEST_MODEL = '___test_model';

    /** @var Model */
    private $modelRepo;
    /** @var  Mark */
    private $markRepo;
    /** @var  EntityManager */
    private $entityManager;

    public function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        $this->sm = \TestBootstrap::app()->getServiceManager();
        /** @var EntityManager entityManager */
        $this->entityManager = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->modelRepo = $this->entityManager->getRepository(\Core\Entity\Model::class);
        $this->markRepo = $this->entityManager->getRepository(\Core\Entity\Mark::class);
        parent::setUp();
    }

    private function cleanTestModels()
    {
        $models = $this->modelRepo->findBy([
            'name' => self::TEST_MODEL,
        ]);
        foreach ($models as $model) {
            $this->entityManager->remove($model);
        }
    }

    /**
     * @test
     */
    public function testFetchModel()
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MODEL_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\model');
        $this->assertControllerClass('model');
        $this->assertMatchedRouteName('modelapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertTrue(count($response->_embedded->models) > 0);
    }

    /**
     * @test
     */
    public function testCreateModelWithInvalidData()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'invalid' => self::TEST_MODEL,
            ]));
        $this->dispatch(Url::API_MODEL_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\model');
        $this->assertControllerClass('model');
        $this->assertMatchedRouteName('modelapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals("Model Name: Value is required and can't be empty", $response->message[0]);
    }

    /**
     * @test
     */
    public function testCreateModelWithValidData()
    {
        $this->cleanTestModels();
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'name' => self::TEST_MODEL,
                'mark_id' => 1,
            ]));
        $this->dispatch(Url::API_MODEL_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\model');
        $this->assertControllerClass('model');
        $this->assertMatchedRouteName('modelapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals(self::TEST_MODEL, $response->name);
    }

    /**
     * @test
     */
    public function testUpdateModel()
    {
        $this->cleanTestModels();
        $entity = new \Core\Entity\Model();
        $entity->setName(self::TEST_MODEL);
        $entity->setMark($this->getMarkTest());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->dispatch(Url::API_MODEL_URL . '/' . $entity->getId(), 'PUT', [
            'name' => self::TEST_MODEL . '_updated',
            'mark_id' => 1,
        ]);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\model');
        $this->assertControllerClass('model');
        $this->assertMatchedRouteName('modelapi');
        $this->assertNull(null);


        $response = $this->fetchEntity($entity);
        $this->assertEquals(self::TEST_MODEL . '_updated', $response->name);
    }

    /**
     *
     */
    public function testDeleteModel()
    {
        $entity = $this->modelRepo->findOneBy([
            'name' => self::TEST_MODEL . '_updated',
        ]);
        $this->dispatch(Url::API_MODEL_URL . '/' . $entity->getId(), 'DELETE');
        $response = $this->fetchEntity($entity);
        $this->assertEquals('API error. Model doesn\'t exist', $response->message);
    }

    /**
     * @param \Core\Entity\Model $entity
     * @return mixed
     */
    private function fetchEntity($entity)
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MODEL_URL . '/' . $entity->getId());
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\model');
        $this->assertControllerClass('model');
        $this->assertMatchedRouteName('modelapi');
        $response = Json::decode($this->getResponse()->getContent());
        return $response;
    }

    private function getMarkTest()
    {
        return $this->markRepo->find(1);
    }
}
