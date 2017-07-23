<?php

namespace API\Controller;

use API\Controller\View\MaintenanceHistoryCollection;
use API\Controller\View\MaintenanceHistoryModel;
use API\Controller\View\ErrorModel;
use API\Controller\View\ErrorValidation;
use API\Exception\MaintenanceHistoryDoesNotExistException;
use API\Exception\MaintenanceHistoryValidationException;
use API\RequestModel\MaintenanceHistory as RequestModel;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use API\Service\MaintenanceHistory as MaintenanceHistoryService;

class MaintenanceHistory extends AbstractRestfulController
{
    /**
     * @var MaintenanceHistoryService
     */
    private $service;

    public function __construct(\API\Service\MaintenanceHistory $service)
    {
        $this->service = $service;
    }

    /**
     * @return MaintenanceHistoryCollection|ErrorModel
     */
    public function getList()
    {
        try {
            $parameters = $this->getRequest()->getQuery();
            $request = new RequestModel($parameters);
            return new MaintenanceHistoryCollection($this->service->getList($request));
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }

    /**
     * @param $id
     * @return MaintenanceHistoryModel|ErrorModel
     */
    public function get($id)
    {
        try {
            return new MaintenanceHistoryModel($this->service->get($id));
        } catch (MaintenanceHistoryDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            return new ErrorModel($e);
        }
    }

    /**
     * @param $data
     * @return MaintenanceHistoryModel|ErrorModel|ErrorValidation
     */
    public function create($data)
    {
        try {
            return new MaintenanceHistoryModel($this->service->create(new RequestModel($data)));
        } catch (MaintenanceHistoryValidationException $e) {
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
            return new JsonModel(['message' => 'MaintenanceHistory has been updated']);
        } catch (MaintenanceHistoryValidationException $e) {
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
            return new JsonModel(['message' => 'MaintenanceHistory has been deleted']);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }
}
