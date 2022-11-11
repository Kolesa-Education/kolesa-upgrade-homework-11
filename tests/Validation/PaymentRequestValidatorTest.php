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
        $correctValues = ["Sleeping Beauty", "Tee Aa"];

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

        foreach ($correctValues as $val) {
            $expected = [];

            $actual = $generator->validateName(
                $val
            );
    
            $this->assertEquals($expected, $actual);
        }
    }
}