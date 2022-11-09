<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Validation\PaymentRequestValidator;

class ValidatorTest extends TestCase
{
    public function testCheckValidator(): void
    {

        $expectedErrors = [
            'Имя не содержит 2 слова',
            'Дата не соответствует формату'
        ];

        $validator = new PaymentRequestValidator();
        $sample = ["name" => "Димас", "cardNumber" => "123123123123", "expiration" => "1/23", "cvv"=>"123"];
        $errors = $validator->validate($sample);

        $this->assertEquals($expectedErrors, $errors);
    }
}