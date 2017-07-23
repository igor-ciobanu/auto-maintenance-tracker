<?php

namespace API\Controller;

use API\Controller\View\MarkCollection;
use API\Controller\View\MarkModel;
use API\Controller\View\ErrorModel;
use API\Controller\View\ErrorValidation;
use API\Exception\MarkDoesNotExistException;
use API\Exception\MarkValidationException;
use API\RequestModel\Mark as RequestModel;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use API\Service\Mark as MarkService;

class Mark extends AbstractRestfulController
{
    /**
     * @var MarkService
     */
    private $service;

    public function __construct(\API\Service\Mark $service)
    {
        $this->service = $service;
    }

    /**
     * @return MarkCollection|ErrorModel
     */
    public function getList()
    {
        try {
            $parameters = $this->getRequest()->getQuery();
            $request = new RequestModel($parameters);
            return new MarkCollection($this->service->getList($request));
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }

    /**
     * @param $id
     * @return MarkModel|ErrorModel
     */
    public function get($id)
    {
        try {
            return new MarkModel($this->service->get($id));
        } catch (MarkDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            return new ErrorModel($e);
        }
    }

    /**
     * @param $data
     * @return MarkModel|ErrorModel|ErrorValidation
     */
    public function create($data)
    {
        try {
            return new MarkModel($this->service->create(new RequestModel($data)));
        } catch (MarkDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (MarkValidationException $e) {
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
            return new JsonModel(['message' => 'Mark has been updated']);
        } catch (MarkValidationException $e) {
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
            return new JsonModel(['message' => 'Mark has been deleted']);
        } catch (MarkDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }
}
