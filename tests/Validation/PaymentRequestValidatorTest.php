<?php

declare(strict_types=1);

namespace App\Validation;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $expected = [];

        $validator = new PaymentRequestValidator();

        $actual = $validator->validate(["name" => "df", "cardNumber" => "df", "expiration" => "df", "cvv" => "df"]);

        $this->assertEquals($expected, $actual);
    }

    public function testValidateName(): void
    {
        $expected = "";

        $validator = new PaymentRequestValidator();

        $actual = $validator->validateName("Ulan");

        $this->assertEquals($expected, $actual);
    }

    public function testValidateCardNumber(): void
    {
        $expected = "";

        $validator = new PaymentRequestValidator();

        $actual = $validator->validateCardNumber("1234567891234");

        $this->assertEquals($expected, $actual);
    }

    public function testValidateExpiration(): void
    {
        $expected = "";

        $validator = new PaymentRequestValidator();

        $actual = $validator->validateExpiration("1/23");

        $this->assertEquals($expected, $actual);
    }

    public function testValidateCvv(): void
    {
        $expected = "";

        $validator = new PaymentRequestValidator();

        $actual = $validator->validateCvv("1234");

        $this->assertEquals($expected, $actual);
    }
}