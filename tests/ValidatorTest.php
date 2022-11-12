<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Validation\PaymentRequestValidator;

class ValidatorTest extends TestCase{

    public function testValidation($data, $expected):void{
        $validator = new PaymentRequestValidator();
        $actual = $validator->validate($data);
        $this->assertEquals($expected, $actual);
    }
}