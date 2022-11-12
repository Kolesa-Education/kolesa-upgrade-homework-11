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
            "Valid information" =>
            [
                [
                    "name" => "Хамбар Дусалиев",
                    "cardNumber" => str_repeat("4", 12),
                    "expiration" => "01/25",
                    "cvv" => "023"
                ],
                []
            ],
            "Invalid information" =>
            [
                [
                    "name" => "Аa",
                    "cardNumber" => str_repeat("1", 14)."abc",
                    "expiration" => "254/75",
                    "cvv" => "12345"
                ],
                [
                    "NAME ERROR: Имя состоит не из 2 слов",
                    "CARDNUMBER ERROR: Строка не состоит из 12 символов",
                    "EXPIRATION ERROR: Строка не состоит из 5 символов",
                    "CVV ERROR: Строка не состоит из 3 символов"
                ]
            ],
            "Invalid CardNumber" =>
            [
                [
                        "name" => "Хамбар Дусалиев",
                        "cardNumber" => str_repeat("1", 13),
                        "expiration" => "01/25",
                        "cvv" => "024"
                ],
                ["CARDNUMBER ERROR: Строка не состоит из 12 символов"]
            ],
            "Invalid Name" =>
            [
                [
                        "name" => "хамбар дусалие1в",
                        "cardNumber" => str_repeat("1", 12),
                        "expiration" => "01/25",
                        "cvv" => "025"
                ],
                [
                    "NAME ERROR: Имя не должно содержать цифры",
                    "NAME ERROR: Имя и Фамилиия должны быть написаны с заглавной буквы"
                ]
            ],
            "Empty" =>
            [
                [
                    "name" => "",
                    "cardNumber" => "",
                    "expiration" => "",
                    "cvv" => ""
                ],
                [
                    "NAME ERROR: Имя состоит не из 2 слов",
                    "CARDNUMBER ERROR: Строка не состоит из 12 символов",
                    "EXPIRATION ERROR: Строка не состоит из 5 символов",
                    "CVV ERROR: Строка не состоит из 3 символов"
                ]
            ]
        ];
    }
}