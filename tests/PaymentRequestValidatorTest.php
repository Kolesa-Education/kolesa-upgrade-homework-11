<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testValidator(array $actualRequest, array $expErr)
    {
        $validator = new PaymentRequestValidator();
        $actualErr = $validator->validate($actualRequest);
        $this->assertEquals($expErr, $actualErr);
    }

    /**
     * @return array[]
     */
    public function dataProvider(): array
    {
        return [
            'valid request1' => [
                [
                    'name' => 'Khambar Dusaliev',
                    'cardNumber' => '1234 5678 9101 1111',
                    'expiration' => '12/25',
                    'cvv' => '012'
                ],
                []
            ],
            'valid request2' => [
                [
                    'name' => 'Li Vi',
                    'cardNumber' => '1234567891011111',
                    'expiration' => '12/25',
                    'cvv' => '412'
                ],
                []
            ],

            'invalid name filed1' => [
                [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => '1234 5678 9101 1121',
                    'expiration' => '12/25',
                    'cvv' => '012'
                ],
                [
                    'неверно введено имя, имя должно состоять только из символов латинского алфавита',
                    'неверно введена фамилия, фамилия состоять только из символов латинского алфавита'
                ]
            ],
            'invalid name filed2' => [
                [
                    'name' => 'I I',
                    'cardNumber' => '1234 5678 9101 1121',
                    'expiration' => '12/25',
                    'cvv' => '012'
                ],
                [
                    'имя должно состоять минимум из двух символов',
                    'фамилия должна состоять минимум из двух символов'
                ]
            ],
            'invalid name filed3' => [
                [
                    'name' => '123 s',
                    'cardNumber' => '1234 5678 9101 1121',
                    'expiration' => '12/25',
                    'cvv' => '012'
                ],
                [
                    'неверно введено имя, имя должно состоять только из символов латинского алфавита',
                    'фамилия должна состоять минимум из двух символов'
                ]
            ],
            'invalid card number' => [
                [
                    'name' => 'Khambar Dusaliev',
                    'cardNumber' => '1234 5678 9101 1ss111',
                    'expiration' => '12/25',
                    'cvv' => '012'
                ],
                [
                    'код карты должен содержать только цифцы с 0 по 9',
                    'код карты должен состоять из 16 цифр'
                ]
            ],
            'invalid card expiration1' => [
                [
                    'name' => 'Khambar Dusaliev',
                    'cardNumber' => '1234 5678 9101 1111',
                    'expiration' => '12/222',
                    'cvv' => '012'
                ],
                [
                    'некорректный формат срока годности карты, корректный формат месяц/год'
                ]
            ],
            'invalid card expiration2' => [
                [
                    'name' => 'Khambar Dusaliev',
                    'cardNumber' => '1234 5678 9101 1111',
                    'expiration' => '122/2s',
                    'cvv' => '012'
                ],
                [
                    'некорректный формат срока годности карты, корректный формат месяц/год'
                ]
            ],
            'invalid card expiration3' => [
                [
                    'name' => 'Khambar Dusaliev',
                    'cardNumber' => '1234 5678 9101 1111',
                    'expiration' => '1231',
                    'cvv' => '012'
                ],
                [
                    'некорректный формат срока годности карты, корректный формат месяц/год',
                ]
            ],
            'invalid cvv1' => [
                [
                    'name' => 'Khambar Dusaliev',
                    'cardNumber' => '1234 5678 9101 1111',
                    'expiration' => '12/23',
                    'cvv' => '0122'
                ],
                [
                    'некорректный код cvv, код должен состоять только из трех цифр'
                ]
            ],
            'invalid cvv2' => [
                [
                    'name' => 'Khambar Dusaliev',
                    'cardNumber' => '1234 5678 9101 1111',
                    'expiration' => '12/23',
                    'cvv' => 's22'
                ],
                [
                    'некорректный код cvv, код должен состоять только цифр'
                ]
            ]
        ];

    }
}