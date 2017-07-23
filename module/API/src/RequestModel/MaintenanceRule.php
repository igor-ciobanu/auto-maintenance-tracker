<?php

namespace API\RequestModel;

class MaintenanceRule extends AbstractRequestModel
{
    public $id;
    public $car_type_id;
    public $maintenance_type_id;
    public $km;
}
