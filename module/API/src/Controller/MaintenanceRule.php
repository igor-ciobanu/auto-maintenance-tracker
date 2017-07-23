<?php

namespace API\Controller;

use API\Controller\View\MaintenanceRuleCollection;
use API\Controller\View\MaintenanceRuleModel;
use API\Controller\View\ErrorModel;
use API\Controller\View\ErrorValidation;
use API\Exception\MaintenanceRuleDoesNotExistException;
use API\Exception\MaintenanceRuleValidationException;
use API\RequestModel\MaintenanceRule as RequestModel;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use API\Service\MaintenanceRule as MaintenanceRuleService;

class MaintenanceRule extends AbstractRestfulController
{
    /**
     * @var MaintenanceRuleService
     */
    private $service;

    public function __construct(\API\Service\MaintenanceRule $service)
    {
        $this->service = $service;
    }

    /**
     * @return MaintenanceRuleCollection|ErrorModel
     */
    public function getList()
    {
        try {
            $parameters = $this->getRequest()->getQuery();
            $request = new RequestModel($parameters);
            return new MaintenanceRuleCollection($this->service->getList($request));
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }

    /**
     * @param $id
     * @return MaintenanceRuleModel|ErrorModel
     */
    public function get($id)
    {
        try {
            return new MaintenanceRuleModel($this->service->get($id));
        } catch (MaintenanceRuleDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            return new ErrorModel($e);
        }
    }

    /**
     * @param $data
     * @return MaintenanceRuleModel|ErrorModel|ErrorValidation
     */
    public function create($data)
    {
        try {
            return new MaintenanceRuleModel($this->service->create(new RequestModel($data)));
        } catch (MaintenanceRuleValidationException $e) {
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
            return new JsonModel(['message' => 'MaintenanceRule has been updated']);
        } catch (MaintenanceRuleDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (MaintenanceRuleValidationException $e) {
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
            return new JsonModel(['message' => 'MaintenanceRule has been deleted']);
        } catch (MaintenanceRuleDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }
}
