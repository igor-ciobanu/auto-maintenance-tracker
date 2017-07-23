<?php

namespace API\RequestModel;

class Car extends AbstractRequestModel
{
    public $id;
    public $vin;
    public $year;
    public $km;
    public $car_type_id;
    public $model_id;
}
