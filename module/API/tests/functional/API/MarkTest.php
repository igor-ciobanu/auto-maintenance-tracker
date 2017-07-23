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
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class MarkTest extends AbstractHttpControllerTestCase
{
    const TEST_MARK = '___test_mark';

    /** @var Mark */
    private $markRepo;
    /** @var  EntityManager */
    private $entityManager;

    public function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        $this->sm = \TestBootstrap::app()->getServiceManager();
        /** @var EntityManager entityManager */
        $this->entityManager = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->markRepo = $this->entityManager->getRepository(\Core\Entity\Mark::class);
        parent::setUp();
    }

    private function cleanTestMarks()
    {
        $marks = $this->markRepo->findBy([
            'name' => self::TEST_MARK,
        ]);
        foreach ($marks as $mark) {
            $this->entityManager->remove($mark);
        }
    }

    /**
     * @test
     */
    public function testFetchMark()
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MARK_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\mark');
        $this->assertControllerClass('mark');
        $this->assertMatchedRouteName('markapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertTrue(count($response->_embedded->marks) > 0);
    }

    /**
     * @test
     */
    public function testCreateMarkWithInvalidData()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'invalid' => self::TEST_MARK,
            ]));
        $this->dispatch(Url::API_MARK_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\mark');
        $this->assertControllerClass('mark');
        $this->assertMatchedRouteName('markapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals("Mark Name: Value is required and can't be empty", $response->message[0]);
    }

    /**
     * @test
     */
    public function testCreateMarkWithValidData()
    {
        $this->cleanTestMarks();
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters([
                'name' => self::TEST_MARK,
            ]));
        $this->dispatch(Url::API_MARK_URL);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\mark');
        $this->assertControllerClass('mark');
        $this->assertMatchedRouteName('markapi');
        $response = Json::decode($this->getResponse()->getContent());
        $this->assertEquals(self::TEST_MARK, $response->name);
    }

    /**
     * @test
     */
    public function testUpdateMark()
    {
        $this->cleanTestMarks();
        $entity = new \Core\Entity\Mark();
        $entity->setName(self::TEST_MARK);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->dispatch(Url::API_MARK_URL . '/' . $entity->getId(), 'PUT', [
            'name' => self::TEST_MARK . '_updated',
        ]);
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\mark');
        $this->assertControllerClass('mark');
        $this->assertMatchedRouteName('markapi');
        $this->assertNull(null);


        $response = $this->fetchEntity($entity);
        $this->assertEquals(self::TEST_MARK . '_updated', $response->name);
    }

    /**
     *
     */
    public function testDeleteMark()
    {
        $entity = $this->markRepo->findOneBy([
            'name' => self::TEST_MARK . '_updated',
        ]);
        $this->dispatch(Url::API_MARK_URL . '/' . $entity->getId(), 'DELETE');
        $response = $this->fetchEntity($entity);
        $this->assertEquals('API error. Mark doesn\'t exist', $response->message);
    }

    /**
     * @param \Core\Entity\Mark $entity
     * @return mixed
     */
    private function fetchEntity($entity)
    {
        $this->getRequest()
            ->setMethod('GET');
        $this->dispatch(Url::API_MARK_URL . '/' . $entity->getId());
        $this->assertModuleName('api');
        $this->assertControllerName('api\controller\mark');
        $this->assertControllerClass('mark');
        $this->assertMatchedRouteName('markapi');
        $response = Json::decode($this->getResponse()->getContent());
        return $response;
    }
}
