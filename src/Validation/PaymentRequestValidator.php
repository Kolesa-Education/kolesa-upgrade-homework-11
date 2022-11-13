<?php

declare(strict_types=1);

namespace App\Validation;


class PaymentRequestValidator
{
    public const INVALID_NAME = "name: Невалидное имя";
    public const INVALID_CARD_NUMBER = "cardNumber: состоит из 16 цифр";
    public const INVALID_CVV = "cvv: не 3-ч значное число";
    public const INVALID_EXPIRATION = "expiration: невалидное значение";

    public function validate(array $request): array
    {
        $name = $request['name'] ?? null;
        $cardNumber = $request['cardNumber'] ?? null;
        $expiration = $request['expiration'] ?? null;
        $cvv = $request['cvv'] ?? null;

        $errors = [];
        if (!$this->isValidNames($name)) {
            $errors[] = self::INVALID_NAME;
        }

        if (!is_numeric($cardNumber) || strlen($cardNumber) !== 16) {
            $errors[] = self::INVALID_CARD_NUMBER;
        }

        if (!$this->isValidExpiration($expiration)) {
            $errors[] = self::INVALID_EXPIRATION;
        }

        if (!is_numeric($cvv) || strlen($cvv) !== 3) {
            $errors[] = self::INVALID_CVV;
        }
        return $errors;
    }

    private function isValidNames(string $names): bool
    {
        $splittedNames = explode(' ', $names);
        if (count($splittedNames) !== 2) {
            return false;
        }
        $firstName = $splittedNames[0] ?? null;
        $lastName = $splittedNames[1] ?? null;
        if (!isset($firstName, $lastName)) {
            return false;
        }
        if (mb_strlen($firstName) < 2 || mb_strlen($lastName) < 2) {
            return false;
        }
        return true;
    }

    private function isValidExpiration(string $expiration): bool
    {
        if (!str_contains($expiration,'/')) {
            return false;
        }
        $pairs = explode("/", $expiration);
        $first = $pairs[0] ?? null;
        $second = $pairs[1] ?? null;
        $firstInt = (int)$first;
        $secondInt = (int)$second;



        if (!$first && !$second) {
            return false;
        }

        if (!is_numeric($first) && !is_numeric($second)) {
            return false;
        }

        if (strlen($first) < 2 || strlen($second) < 2) {
            return false;
        }

        $pairsMax = $firstInt <= 12 && $secondInt <= 25;


        if (!$pairsMax) {
            return false;
        }

        if ($first[0] === '0') {
            $firstMin = $firstInt >= 1;
        } else {
            $firstMin = $firstInt >= 10;
        }

        $secondMin = $secondInt >= 22;


        if (!$firstMin || !$secondMin) {
            return false;
        }

        return true;
    }
}