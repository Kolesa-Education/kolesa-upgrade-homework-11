<?php

declare(strict_types=1);

use App\Validation;
use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testNameValidation(): void
    {
        $generator = new PaymentRequestValidator();

        $wrongWordCounts = ["Markhabat", "Robert Downey Jr"];
        $wrongBoth = ["M", ""];
        $validValues = ["Sleeping Beauty", "Tee Aa"];

        foreach ($wrongWordCounts as $val) {
            $expected = [PaymentRequestValidator::NAME_COUNT_ERROR];

            $actual = $generator->validateName(
                $val
            );
    
            $this->assertEquals($expected, $actual);
        }

        foreach ($wrongBoth as $val) {
            $expected = [PaymentRequestValidator::NAME_COUNT_ERROR, PaymentRequestValidator::NAME_WORD_LEN_ERROR];

            $actual = $generator->validateName(
                $val
            );
    
            $this->assertEquals($expected, $actual);
        }

        foreach ($validValues as $val) {
            $expected = [];

            $actual = $generator->validateName(
                $val
            );
    
            $this->assertEquals($expected, $actual);
        }
    }

    public function testValidateCard(): void
    {
        $generator = new PaymentRequestValidator();

        $allErrorsValues = [
            'cardNumber' => '123h',
            'expiration' => 'as/287',
            'cvv' => '62'
        ];

        $expected = [
            PaymentRequestValidator::CARD_NUMBER_LEN_ERROR,
            PaymentRequestValidator::NOT_DIGIT_ERROR,
            PaymentRequestValidator::EXPIRATION_FORMAT_ERROR,
            PaymentRequestValidator::EXPIRATION_DIGITS_ERROR,
            PaymentRequestValidator::FIRST_DIGIT_ERROR,
            PaymentRequestValidator::SECOND_DIGIT_ERROR,
            PaymentRequestValidator::CVV_ERROR,
        ];

        $actual = $generator->validateCard($allErrorsValues['cardNumber'], $allErrorsValues['expiration'], $allErrorsValues['cvv']);

        $this->assertEquals($expected, $actual);
    }

    public function testValidate(): void
    {
        $generator = new PaymentRequestValidator();

        $validValues = [
            'name' => 'Nana Lee',
            'cardNumber' => '012345678912',
            'expiration' => '12/24',
            'cvv' => '908'
        ];

        $expected = [];

        $actual = $generator->validate($validValues);

        $this->assertEquals($expected, $actual);
    }
}