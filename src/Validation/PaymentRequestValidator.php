<?php

declare(strict_types=1);

namespace App\Validation;

use PHPUnit\Framework\TestCase;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $card = new Card($request["name"], $request["cardNumber"], $request["expiration"], $request["cvv"]);
        $nameErrors = $card->validateName() ?? null;
        $cardNumberErrors = $card->validateCardNumber() ?? null;
        $expirationErrors = $card->validateExpiration() ?? null;
        $cvvErrors = $card->validateCvv() ?? null;
        return array_merge($nameErrors, $cardNumberErrors, $expirationErrors, $cvvErrors);
    }
}