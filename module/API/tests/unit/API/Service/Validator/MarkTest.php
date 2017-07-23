<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 21/07/17
 * Time: 3:41 PM
 */

namespace unit\API\Service\Validator;

use API\RequestModel\Mark;
use PHPUnit\Framework\TestCase;

class MarkTest extends TestCase
{
    public function testValidator()
    {
        $request = new Mark([]);
        $validator = new \API\Service\Validator\Mark();
        $validator->validate($request);
        $this->assertTrue($validator->hasErrors());
        $this->assertEquals(1, count($validator->getErrors()));
    }
}
