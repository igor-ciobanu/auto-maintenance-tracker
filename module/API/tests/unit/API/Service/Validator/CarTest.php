<?php

namespace unit\API\Service\Validator;

use API\RequestModel\Car;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    public function testValidator()
    {
        $request = new Car([]);
        $validator = new \API\Service\Validator\Car();
        $validator->validate($request);
        $this->assertTrue($validator->hasErrors());
        $this->assertEquals(9, count($validator->getErrors()));
    }
}
