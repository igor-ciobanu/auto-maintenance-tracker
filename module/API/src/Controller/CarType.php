<?php

namespace API\Controller;

use API\Controller\View\CarTypeCollection;
use API\Controller\View\CarTypeModel;
use API\Controller\View\ErrorModel;
use API\Controller\View\ErrorValidation;
use API\Exception\CarTypeDoesNotExistException;
use API\Exception\CarTypeValidationException;
use API\RequestModel\CarType as RequestModel;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use API\Service\CarType as CarTypeService;

class CarType extends AbstractRestfulController
{
    /**
     * @var CarTypeService
     */
    private $service;

    public function __construct(\API\Service\CarType $service)
    {
        $this->service = $service;
    }

    /**
     * @return CarTypeCollection|ErrorModel
     */
    public function getList()
    {
        try {
            $parameters = $this->getRequest()->getQuery();
            $request = new RequestModel($parameters);
            return new CarTypeCollection($this->service->getList($request));
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }

    /**
     * @param $id
     * @return CarTypeModel|ErrorModel
     */
    public function get($id)
    {
        try {
            return new CarTypeModel($this->service->get($id));
        } catch (CarTypeDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            return new ErrorModel($e);
        }
    }

    /**
     * @param $data
     * @return CarTypeModel|ErrorModel|ErrorValidation
     */
    public function create($data)
    {
        try {
            return new CarTypeModel($this->service->create(new RequestModel($data)));
        } catch (CarTypeValidationException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_400);
            return new ErrorValidation($e);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }

    /**
     * @param $id
     * @param $data
     * @return ErrorModel|ErrorValidation|JsonModel
     */
    public function update($id, $data)
    {
        try {
            $request = new RequestModel($data);
            $request->id = $id;
            $this->service->update($request);
            return new JsonModel(['message' => 'CarType has been updated']);
        } catch (CarTypeDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (CarTypeValidationException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_400);
            return new ErrorValidation($e);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }

    /**
     * @param $id
     * @return ErrorModel|JsonModel
     */
    public function delete($id)
    {
        try {
            $this->service->delete($id);
            return new JsonModel(['message' => 'CarType has been deleted']);
        } catch (CarTypeDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }
}
