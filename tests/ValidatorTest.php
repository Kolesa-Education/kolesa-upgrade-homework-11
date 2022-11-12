<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Validation\PaymentRequestValidator;

class ValidatorTest extends TestCase{

    /**
     * @dataProvider additionProvider
     */

    public function testValidation($name,$cardNumber,$expiration,$cvv,$expected):void{

        $validator = new PaymentRequestValidator();
        $actual = $validator -> validate([
            "name" => $name,
            "cardNumber" => $cardNumber,
            "expiration" => $expiration,
            "cvv" => $cvv,
        ]);
        $this->assertEquals($expected, $actual);
    }

    public function additionProvider(): array
    {
        return [
            [
                'Димас',
                '12345678910',
                '12/26',
                '11',
                [
                    'name не состоит их 2-х слов',
                    'номер карты должен содержать из 16 цифр',
                    'максимальное значение для вторых пар чисел - 25',
                    'cvv не трехзначное число'
                ]
            ],
        ];
    }
}
