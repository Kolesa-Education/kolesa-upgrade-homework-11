<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testEmptyInputs(): void
    {
        $empty = array(
            'name' => '',
            'cardNumber' => '',
            'expiration' => '',
            'cvv' => ''
        );

        $expected = [
            PaymentRequestValidator::INVALID_NAME,
            PaymentRequestValidator::INVALID_CARD_NUMBER,
            PaymentRequestValidator::INVALID_EXPIRATION,
            PaymentRequestValidator::INVALID_CVV,
        ];

        $validator = new PaymentRequestValidator();

        $actual = $validator->validate($empty);

        $this->assertEquals($expected, $actual);
    }

    public function testInvalidName(): void
    {
        $testInputs = array(
            'cardNumber' => '1234567890123456',
            'expiration' => '12/31',
            'cvv' => '834'
        );

        $expected = [
            PaymentRequestValidator::INVALID_NAME,
        ];

        $invalidFields = [
            $testInputs + ['name' => 'Жигули'],
            $testInputs + ['name' => 'Дональд Трамп Байболсынов'],
            $testInputs + ['name' => 'Мелман'],
            $testInputs + ['name' => 'Панда Кунг Фу'],
        ];

        $validator = new PaymentRequestValidator();

        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testInvalidCardNumber(): void
    {
        $testInputs = array(
            'name' => 'Массагет Харитонов',
            'expiration' => '07/04',
            'cvv' => '006'
        );

        $expected = [
            PaymentRequestValidator::INVALID_CARD_NUMBER
        ];

        $invalidFields = array (
            $testInputs + ['cardNumber' => ''],
            $testInputs + ['cardNumber' => '9'],
            $testInputs + ['cardNumber' => '12345678901234567'],
            $testInputs + ['cardNumber' => '123456789012345a'],
        );

        $validator = new PaymentRequestValidator();

        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testInvalidExpiration(): void
    {
        $testInputs = array(
            'name' => 'Kung Lao',
            'cardNumber' => '1234567890123456',
            'cvv' => '987'
        );

        $expected = [
            PaymentRequestValidator::INVALID_EXPIRATION,
        ];

        $invalidFields = array (
            $testInputs + ['expiration' => '01/32'],
            $testInputs + ['expiration' => '12/32'],
            $testInputs + ['expiration' => '0/01'],
            $testInputs + ['expiration' => '01.01'],
            $testInputs + ['expiration' => '0101'],
            $testInputs + ['expiration' => '404'],
        );

        $validator = new PaymentRequestValidator();

        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testInvalidCvv(): void
    {
        $testInputs = array(
            'name' => 'King Kong',
            'cardNumber' => '1234567890123456',
            'expiration' => '21/00',
        );

        $expected = [
            PaymentRequestValidator::INVALID_CVV,
        ];

        $invalidFields = array (
            $testInputs + ['cvv' => 'g'],
            $testInputs + ['cvv' => '321'],
            $testInputs + ['cvv' => '000'],
        );
        $validator = new PaymentRequestValidator();
        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testAllCorrect(): void
    {
        $testInputs = array(
            'name' => 'Ilon Musk Talgatovich',
            'cardNumber' => '6543210987654321',
            'expiration' => '01/01',
            'cvv' => '111'
        );
        $expected = [];
        $validator = new PaymentRequestValidator();
        $actual = $validator->validate($testInputs);
        $this->assertEquals($expected, $actual);
    }
}