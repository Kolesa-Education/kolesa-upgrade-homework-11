<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Validation\PaymentRequestValidator;

class ValidatorTest extends TestCase{
   /**
     * @dataProvider additionProvider
     */
    public function testValidate($data, $expected)
    {
        $validator = new PaymentRequestValidator();
        $actual = $validator->validate($data);
        $this->assertEquals($expected, $actual);
    }

    public function additionProvider(): array
    {
        return
        [
            "Valid information" =>
            [
                [
                    "name" => "Хамбар Дусалиев",
                    "cardNumber" => str_repeat("0", 12),
                    "expiration" => "01/25",
                    "cvv" => "023"
                ],
                []
            ]
        ];
    }
}