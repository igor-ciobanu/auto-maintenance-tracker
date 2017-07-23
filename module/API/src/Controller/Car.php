<?php

namespace API\Controller;

use API\Controller\View\CarCollection;
use API\Controller\View\CarModel;
use API\Controller\View\ErrorModel;
use API\Controller\View\ErrorValidation;
use API\Exception\CarDoesNotExistException;
use API\Exception\CarValidationException;
use API\RequestModel\Car as RequestModel;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use API\Service\Car as CarService;

class Car extends AbstractRestfulController
{
    /**
     * @var CarService
     */
    private $service;

    public function __construct(\API\Service\Car $service)
    {
        $this->service = $service;
    }

    /**
     * @return CarCollection|ErrorModel
     */
    public function getList()
    {
        try {
            $parameters = $this->getRequest()->getQuery();
            $request = new RequestModel($parameters);
            return new CarCollection($this->service->getList($request));
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }

    /**
     * @param $id
     * @return CarModel|ErrorModel
     */
    public function get($id)
    {
        try {
            return new CarModel($this->service->get($id));
        } catch (CarDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            return new ErrorModel($e);
        }
    }

    /**
     * @param $data
     * @return CarModel|ErrorModel|ErrorValidation
     */
    public function create($data)
    {
        try {
            return new CarModel($this->service->create(new RequestModel($data)));
        } catch (CarValidationException $e) {
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
            return new JsonModel(['message' => 'Car has been updated']);
        } catch (CarDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (CarValidationException $e) {
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
            return new JsonModel(['message' => 'Car has been deleted']);
        } catch (CarDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }
}
