<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 21/07/17
 * Time: 10:16 AM
 */

namespace API\RequestModel;

class MaintenanceHistory extends AbstractRequestModel
{
    public $id;
    public $car_id;
    public $maintenance_rule_id;
    public $km;
}
