<?php

namespace API\Controller;

use API\Controller\View\MaintenanceTypeCollection;
use API\Controller\View\MaintenanceTypeModel;
use API\Controller\View\ErrorModel;
use API\Controller\View\ErrorValidation;
use API\Exception\MaintenanceTypeDoesNotExistException;
use API\Exception\MaintenanceTypeValidationException;
use API\RequestModel\MaintenanceType as RequestModel;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use API\Service\MaintenanceType as MaintenanceTypeService;

class MaintenanceType extends AbstractRestfulController
{
    /**
     * @var MaintenanceTypeService
     */
    private $service;

    public function __construct(\API\Service\MaintenanceType $service)
    {
        $this->service = $service;
    }

    /**
     * @return MaintenanceTypeCollection|ErrorModel
     */
    public function getList()
    {
        try {
            $parameters = $this->getRequest()->getQuery();
            $request = new RequestModel($parameters);
            return new MaintenanceTypeCollection($this->service->getList($request));
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }

    /**
     * @param $id
     * @return MaintenanceTypeModel|ErrorModel
     */
    public function get($id)
    {
        try {
            return new MaintenanceTypeModel($this->service->get($id));
        } catch (MaintenanceTypeDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            return new ErrorModel($e);
        }
    }

    /**
     * @param $data
     * @return MaintenanceTypeModel|ErrorModel|ErrorValidation
     */
    public function create($data)
    {
        try {
            return new MaintenanceTypeModel($this->service->create(new RequestModel($data)));
        } catch (MaintenanceTypeValidationException $e) {
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
            return new JsonModel(['message' => 'MaintenanceType has been updated']);
        } catch (MaintenanceTypeDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (MaintenanceTypeValidationException $e) {
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
            return new JsonModel(['message' => 'MaintenanceType has been deleted']);
        } catch (MaintenanceTypeDoesNotExistException $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return new ErrorModel($e);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new ErrorModel($e);
        }
    }
}
