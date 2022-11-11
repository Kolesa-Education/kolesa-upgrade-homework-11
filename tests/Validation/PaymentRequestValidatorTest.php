<?php

declare(strict_types=1);

use App\Validation;
use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function testNameValidation(): void
    {
        $expected = [PaymentRequestValidator::NAME_COUNT_ERROR];

        $generator = new PaymentRequestValidator();

        $actual = $generator->validateName(
            "Markhabat"
        );

        $this->assertEquals($expected, $actual);
    }
}