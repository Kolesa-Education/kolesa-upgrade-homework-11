<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    private const MIN_NAME_LENGTH = 2;
    private const CARD_NUMBER_LENGTH = 12;
    private const MAX_MONTH_VALUE = 12;
    private const MAX_YEAR_VALUE = 25;
    private const MIN_MONTH_VALUE = 01;
    private const MIN_YEAR_VALUE = 22;
    private const CVV_LENGTH = 3;

    /**
     * @dataProvider validateNameProvider
     * @param $input
     * @param $expected
     */
    public function testValidate($input, $expected)
    {
        $paymentRequestValidator = new PaymentRequestValidator();

        $actual = $paymentRequestValidator->validate($input);
        $this->assertEquals($expected, $actual);
    }

    public function validateNameProvider()
    {
        return [
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/25',
                    'cvv' => '555',
                ],
                'expected' => [],
            ],
            [
                'input' => [
                    'name' => 'Димас',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/25',
                    'cvv' => '555',
                ],
                'expected' => [
                    'nameString' => 'Имя должно состоять из 2-х слов, разделенных пробелом',
                ],
            ],
            [
                'input' => [
                    'name' => 'А Б',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/25',
                    'cvv' => '555',
                ],
                'expected' => [
                    'nameLength' => 'Минимальная длина слова - ' . self::MIN_NAME_LENGTH . ' символа',
                ],
            ],
            [
                'input' => [
                    'name' => '',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/25',
                    'cvv' => '555',
                ],
                'expected' => [
                    'nameString' => 'Имя должно состоять из 2-х слов, разделенных пробелом',
                    'nameLength' => 'Минимальная длина слова - ' . self::MIN_NAME_LENGTH . ' символа',
                ],
            ],
            [
                'input' => [
                    'name' => 'Болат Болатбеков Болатович',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/25',
                    'cvv' => '555',
                ],
                'expected' => [
                    'nameString' => 'Имя должно состоять из 2-х слов, разделенных пробелом',
                ],
            ],
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => 'fakeCardNumber',
                    'expiration' => '01/25',
                    'cvv' => '555',
                ],
                'expected' => [
                    'cardNumber' => 'Номер карты должен состоять из ' . self::CARD_NUMBER_LENGTH . ' символов',
                ],
            ],
            [
                'input' => [
                    'name' => 'Болат Болатбеков Болатович',
                    'cardNumber' => 'fakeCardNumber',
                    'expiration' => '01/25',
                    'cvv' => '555',
                ],
                'expected' => [
                    'nameString' => 'Имя должно состоять из 2-х слов, разделенных пробелом',
                    'cardNumber' => 'Номер карты должен состоять из ' . self::CARD_NUMBER_LENGTH . ' символов',
                ],
            ],
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => 'fakeCardNumber',
                    'expiration' => '1125',
                    'cvv' => '555',
                ],
                'expected' => [
                    'cardNumber' => 'Номер карты должен состоять из ' . self::CARD_NUMBER_LENGTH . ' символов',
                    'expirationDateFormat' => 'Неверный формат данных, необходимый формат: {число}{число}/{число}{число}',
                ],
            ],
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => 'fakeCardNumber',
                    'expiration' => '13/25',
                    'cvv' => '555',
                ],
                'expected' => [
                    'cardNumber' => 'Номер карты должен состоять из ' . self::CARD_NUMBER_LENGTH . ' символов',
                    'expirationMaxValues' =>
                        'Максимальное значение месяца - ' . self::MAX_MONTH_VALUE .
                        ', максимальное значение года - ' . self::MAX_YEAR_VALUE,
                ],
            ],
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => 'fakeCardNumber',
                    'expiration' => '11/35',
                    'cvv' => '555',
                ],
                'expected' => [
                    'cardNumber' => 'Номер карты должен состоять из ' . self::CARD_NUMBER_LENGTH . ' символов',
                    'expirationMaxValues' =>
                        'Максимальное значение месяца - ' . self::MAX_MONTH_VALUE .
                        ', максимальное значение года - ' . self::MAX_YEAR_VALUE,
                ],
            ],
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => 'fakeCardNumber',
                    'expiration' => '00/25',
                    'cvv' => '555',
                ],
                'expected' => [
                    'cardNumber' => 'Номер карты должен состоять из ' . self::CARD_NUMBER_LENGTH . ' символов',
                    'expirationMaxValues' =>
                        'Минимальное значение месяца - ' . self::MIN_MONTH_VALUE .
                        ', минимальное значение года - ' . self::MIN_YEAR_VALUE,
                ],
            ],
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => 'fakeCardNumber',
                    'expiration' => '01/18',
                    'cvv' => '555',
                ],
                'expected' => [
                    'cardNumber' => 'Номер карты должен состоять из ' . self::CARD_NUMBER_LENGTH . ' символов',
                    'expirationMaxValues' =>
                        'Минимальное значение месяца - ' . self::MIN_MONTH_VALUE .
                        ', минимальное значение года - ' . self::MIN_YEAR_VALUE,
                ],
            ],
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/25',
                    'cvv' => 'fake',
                ],
                'expected' => [
                    'cvv' => 'CVV код должен быть 3-х значным числом',
                ],
            ],
            [
                'input' => [
                    'name' => 'Хамбар Дусалиев',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/25',
                    'cvv' => '12',
                ],
                'expected' => [
                    'cvv' => 'CVV код должен быть 3-х значным числом',
                ],
            ],
        ];
    }
}
