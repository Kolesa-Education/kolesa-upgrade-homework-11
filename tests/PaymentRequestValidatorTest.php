<?php

declare (strict_types = 1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $expected = [
            
        ];

        $validator = new PaymentRequestValidator();

        $actual = $validator->validate([
            'name' => 'ab cd',
            'cardNumber' => '123456789123',
            'expiration' => '01/22',
            'cvv' => '000',
        ]);

        $this->assertEquals($expected, $actual);
    }
}