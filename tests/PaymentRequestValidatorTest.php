<?php

declare (strict_types = 1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $expected = [
            //'name' => 'name must consist of two words',
            //'name' => 'firstname and lastname must be at least 2 chars',
            //'cardNumber' => 'cardNumber cannot be empty',
            //'cardNumber' => 'cardNumber must be 12 chars & numeric',
            //'expiration' => 'expiration cannot be empty',
            //'expiration' => 'expiration must consist of {number}{number}/{number}{number}',
            //'expiration' => 'expiration month and year must be 2 chars each',
            //'expiration' => 'expiration must consist of month from 01 to 12 and year from 22 to 25',
            //'cvv' => 'cvv cannot be empty',
            //'cvv' => 'cvv must be 3 chars & numeric',
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
