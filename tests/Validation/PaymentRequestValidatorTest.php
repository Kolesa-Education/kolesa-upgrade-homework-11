<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testEmptyInputs(): void
    {
        $empty = array(
            'name' => ' ',
            'cardNumber' => ' ',
            'expiration' => ' ',
            'cvv' => ' '
        );

        $expected = [
            "Name is incorrect.",
            "Card number is incorrect.",
            "Expiration is invalid.",
            "Invalid CVV.",
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
            "Name is incorrect."
        ];

        $invalidFields = [
            $testInputs + ['name' => 'JohnDoe'],
            $testInputs + ['name' => 'J D'],
            $testInputs + ['name' => 'John'],
            $testInputs + ['name' => 'John Raynald Doe'],
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
            'name' => 'John Doe',
            'expiration' => '12/23',
            'cvv' => '012'
        );

        $expected = [
            "Card number is incorrect."
        ];

        $invalidFields = array (
            $testInputs + ['cardNumber' => '1'],
            $testInputs + ['cardNumber' => '12341234123412345'],
            $testInputs + ['cardNumber' => '1234123412k41234'],
            $testInputs + ['cardNumber' => '1234 234 12341234'],
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
            "Expiration is invalid."
        ];

        $invalidFields = array (
            $testInputs + ['expiration' => '12/30'],
            $testInputs + ['expiration' => '12/12'],
            $testInputs + ['expiration' => '00/12'],
            $testInputs + ['expiration' => '/30'],
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
            "Invalid CVV."
        ];

        $invalidFields = array (
            $testInputs + ['cvv' => '0'],
            $testInputs + ['cvv' => '01'],
            $testInputs + ['cvv' => '0123'],
            $testInputs + ['cvv' => '0 1'],
            $testInputs + ['cvv' => ' .1'],
            $testInputs + ['cvv' => '1 1'],
        );

        $validator = new PaymentRequestValidator();

        foreach ($invalidFields as $testInput) {
            $actual = $validator->validate($testInput);
            $this->assertEquals($expected, $actual);
        }
    }
}
