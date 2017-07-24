<?php

namespace unit\API\Service\Validator;

use API\RequestModel\MaintenanceType;
use PHPUnit\Framework\TestCase;

class MaintenanceTypeTest extends TestCase
{
    public function testValidator()
    {
        $request = new MaintenanceType([]);
        $validator = new \API\Service\Validator\MaintenanceType();
        $validator->validate($request);
        $this->assertTrue($validator->hasErrors());
        $this->assertEquals(1, count($validator->getErrors()));
    }
}
