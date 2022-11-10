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
                    "name" => "Андреев Денис",
                    "cardNumber" => str_repeat("1", 12),
                    "expiration" => "01/25",
                    "cvv" => "023"
                ],
                []
            ],
            "Everything is invalid" =>
            [
                [
                    "name" => "Аф",
                    "cardNumber" => str_repeat("1", 13)."abc",
                    "expiration" => "1/26",
                    "cvv" => "12"
                ],
                [
                    "name не состоит из 2 слов",
                    "CardNumber не состоит из 12 символов",
                    "expiration не в формате 00/00",
                    "CVV должен состоять из 3 цифр"
                ]
            ],
            "One is invalid" =>
            [
                [
                        "name" => "Андреев Денис",
                        "cardNumber" => str_repeat("1", 13),
                        "expiration" => "01/25",
                        "cvv" => "023"
                ],
                ["CardNumber не состоит из 12 символов"]
            ],
            "Everything is empty" =>
            [
                [
                    "name" => "",
                    "cardNumber" => "",
                    "expiration" => "",
                    "cvv" => ""
                ],
                [
                    "name не состоит из 2 слов",
                    "CardNumber не состоит из 12 символов",
                    "Не соответствует количество символов expiration",
                    "CVV должен состоять из 3 цифр"
                ]
            ]
        ];
    }
}