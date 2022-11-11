<?php

declare(strict_types=1);

namespace App\Validation;

use PHPUnit\Framework\TestCase;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $name = $request["name"] ?? "";
        $cardNumber = $request["cardNumber"] ?? "";
        $expiration = $request["expiration"] ?? "";
        $cvv = $request["cvv"] ?? "";
        $card = new Card($name, $cardNumber, $expiration, $cvv);
        $nameErrors = $card->validateName() ?? null;
        $cardNumberErrors = $card->validateCardNumber() ?? null;
        $expirationErrors = $card->validateExpiration() ?? null;
        $cvvErrors = $card->validateCvv() ?? null;
        return array_merge($nameErrors, $cardNumberErrors, $expirationErrors, $cvvErrors);
    }
}