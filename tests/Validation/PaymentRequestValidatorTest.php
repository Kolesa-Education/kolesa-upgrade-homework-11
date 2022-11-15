<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testEmptyInputs(): void
    {
        $empty = [
            'name' => ' ',
            'cardNumber' => ' ',
            'expiration' => ' ',
            'cvv' => ' '
        ];

        $expected = [
            "Имя и фамилия указаны некорректно.",
            "Номер карты указан некорректно.",
            "Срок действия карты указан некорректно.",
            "CVV код указан некорректно.",
        ];

        $validator = new PaymentRequestValidator();

        $actual = $validator->validate($empty);

        $this->assertEquals($expected, $actual);
    }

    public function testInvalidName(): void
    {
        $testInputs = [
            'cardNumber' => '1234567890123456',
            'expiration' => '12/24',
            'cvv' => '123'
        ];

        $expected = [
            "Имя и фамилия указаны некорректно."
        ];

        $invalidFields = [
            $testInputs + ['name' => 'ArikunKerr'],
            $testInputs + ['name' => 'A K'],
            $testInputs + ['name' => 'Arikun'],
            $testInputs + ['name' => 'Arikun hAckeeVo Kerr'],
        ];

        $validator = new PaymentRequestValidator();

        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testInvalidCardNumber(): void
    {
        $testInputs = [
            'name' => 'Arikun Kerr',
            'expiration' => '12/24',
            'cvv' => '123'
        ];

        $expected = [
            "Номер карты указан некорректно."
        ];

        $invalidFields = [
            $testInputs + ['cardNumber' => '1'],
            $testInputs + ['cardNumber' => '12345678901234567'],
            $testInputs + ['cardNumber' => '123456789012345a'],
            $testInputs + ['cardNumber' => '1234 5678 901234'],
        ];

        $validator = new PaymentRequestValidator();

        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testInvalidExpiration(): void
    {
        $testInputs = [
            'name' => 'Arikun Kerr',
            'cardNumber' => '1234567890123456',
            'cvv' => '123'
        ];

        $expected = [
            "Срок действия карты указан некорректно."
        ];

        $invalidFields = [
            $testInputs + ['expiration' => '12/28'],
            $testInputs + ['expiration' => '12/21'],
            $testInputs + ['expiration' => '00/12'],
            $testInputs + ['expiration' => '/22'],
            $testInputs + ['expiration' => '12-24'],
            $testInputs + ['expiration' => '12.24'],
            $testInputs + ['expiration' => '1224'],
            $testInputs + ['expiration' => '122'],
        ];

        $validator = new PaymentRequestValidator();

        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testInvalidCvv(): void
    {
        $testInputs = [
            'name' => 'Arikun Kerr',
            'cardNumber' => '1234567890123456',
            'expiration' => '12/24',
        ];

        $expected = [
            "CVV код указан некорректно."
        ];

        $invalidFields = [
            $testInputs + ['cvv' => '1'],
            $testInputs + ['cvv' => '12'],
            $testInputs + ['cvv' => '1234'],
            $testInputs + ['cvv' => '0 1'],
            $testInputs + ['cvv' => ' -1'],
            $testInputs + ['cvv' => ' .1'],
            $testInputs + ['cvv' => '1 1'],
            $testInputs + ['cvv' => '1 2'],
        ];

        $validator = new PaymentRequestValidator();

        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testAllCorrect(): void
    {
        $testInputs = [
            'name' => 'Arikun Kerr',
            'cardNumber' => '1234567890123456',
            'expiration' => '12/24',
            'cvv' => '123'
        ];

        $expected = [];

        $validator = new PaymentRequestValidator();

        $actual = $validator->validate($testInputs);
        $this->assertEquals($expected, $actual);
    }
}