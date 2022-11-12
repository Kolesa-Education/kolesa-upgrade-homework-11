<?php

namespace Validation;

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{

    /**
     * @dataProvider additionProvider
     */
    public function testValidate($data, $expected)
    {
        $validator = new PaymentRequestValidator();
        $actual = $validator->validate($data);
        $this->assertEquals($expected, $actual);
    }

    public function additionProvider()
    {
        return
        [
            "Everything is valid" =>
            [
                [
                    "name" => "Abigail Jackson",
                    "cardNumber" => "123456789456",
                    "expiration" => "04/24",
                    "cvv" => "156"
                ],
                []
            ],
            "Everything is invalid" =>
            [
                [
                    "name" => "Khambar",
                    "cardNumber" => "15678945dssd45",
                    "expiration" => "5/24",
                    "cvv" => "1"
                ],
                [
                    "name должен состоять 2-х слов",
                    "card number должен быть из 12 цифр",
                    "Срок истечения срока не введен корректно",
                    "cvv должен состоять из 3 цифр"
                ]
            ],
            "One is invalid" =>
            [
                [
                    "name" => "Abigail Jackson",
                    "cardNumber" => "1234567894565",
                    "expiration" => "08/24",
                    "cvv" => "685"
                ],
                ["card number должен быть из 12 цифр"]
            ]
        ];
    }
}