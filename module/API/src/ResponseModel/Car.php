<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 21/07/17
 * Time: 8:31 AM
 */

namespace API\ResponseModel;

class Car
{
    /** @var  \Core\Entity\Car */
    public $car;
    /** @var  array */
    public $nextMaintenances = [];
}
