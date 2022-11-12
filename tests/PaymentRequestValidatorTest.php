<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $request = ['name' => 'Alexey Kochevoy', 'cardNumber' => '544 322 377 437', 'expiration' => '13 22', 'cvv' => '655'];

        $expected = [
            "You must enter expiration in format : month/year!!!"
        ];

        $validator = new PaymentRequestValidator();

        $actual = $validator->validate($request);

        print_r($expected);
        print_r($actual);

        $this->assertEquals($expected, $actual);
    }
}