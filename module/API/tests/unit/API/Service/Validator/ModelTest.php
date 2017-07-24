<?php

namespace unit\API\Service\Validator;

use API\RequestModel\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    public function testValidator()
    {
        $request = new Model([]);
        $validator = new \API\Service\Validator\Model();
        $validator->validate($request);
        $this->assertTrue($validator->hasErrors());
        $this->assertEquals(3, count($validator->getErrors()));
    }
}
