<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class ReceiptValTest extends TestCase
{
    public function testCheckValidator(): void
    {

        $expErr = [
            'Имя не правильна',
            'формат даты'
        ];

        $val = new PaymentRequestValidator();
        $example = ["name" => "Митхун", "cardNumber" => "123123123123", "expiration" => "11/26", "cvv" => "123"];
        $errors = $val->validate($example);

        $this->assertEquals($expErr, $errors);
    }
}