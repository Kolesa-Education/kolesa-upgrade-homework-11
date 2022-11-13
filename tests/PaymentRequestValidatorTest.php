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
            'cardNumber' => '1234123412341234',
            'expiration' => '12/23',
            'cvv' => '012'
        );

        $expected = [
            PaymentRequestValidator::INVALID_NAME,
        ];

        $invalidFields = [
            $testInputs + ['name' => 'Димас'],
            $testInputs + ['name' => 'ВиниПух'],
            $testInputs + ['name' => 'А Б'],
            $testInputs + ['name' => 'Болат Болатбеков Болатович'],
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
            'name' => 'Хамбар Дусалиев',
            'expiration' => '01/23',
            'cvv' => '987'
        );

        $expected = [
            PaymentRequestValidator::INVALID_CARD_NUMBER
        ];

        $invalidFields = array (
            $testInputs + ['cardNumber' => '1'],
            $testInputs + ['cardNumber' => '12341234123412345'],
            $testInputs + ['cardNumber' => '1234 234 12341234'],
            $testInputs + ['cardNumber' => '123412341241234asd'],
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
            'name' => 'John Doe',
            'cardNumber' => '1234123412341234',
            'cvv' => '012'
        );

        $expected = [
            PaymentRequestValidator::INVALID_EXPIRATION,
        ];

        $invalidFields = array (
            $testInputs + ['expiration' => '12/12'],
            $testInputs + ['expiration' => '01/12'],
            $testInputs + ['expiration' => '/12'],
            $testInputs + ['expiration' => '12.22'],
            $testInputs + ['expiration' => '1222'],
            $testInputs + ['expiration' => '222'],
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
            'name' => 'John Doe',
            'cardNumber' => '1234123412341234',
            'expiration' => '12/23',
        );

        $expected = [
            PaymentRequestValidator::INVALID_CVV,
        ];

        $invalidFields = array (
            $testInputs + ['cvv' => '0'],
            $testInputs + ['cvv' => '01'],
            $testInputs + ['cvv' => '0123'],
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
            'name' => 'Хамбар Дусалиев',
            'cardNumber' => '1234123412341234',
            'expiration' => '01/23',
            'cvv' => '987'
        );
        $expected = [];
        $validator = new PaymentRequestValidator();
        $actual = $validator->validate($testInputs);
        $this->assertEquals($expected, $actual);
    }
}