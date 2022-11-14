<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $name = $request['name'] ?? null;
        $cardNumber = $request['cardNumber'] ?? null;
        $expiration = $request['expiration'] ?? null;
        $cvv = $request['cvv'] ?? null;

        $errors = [];


        if (!self::checkName($name)) {
            array_push($errors, "Name is incorrect.");
        }

        if (!self::checkCardNumber($cardNumber)) {
            array_push($errors, "Card number is incorrect.");
        }

        if (!self::checkExpiration($expiration)) {
            array_push($errors, "Expiration is invalid.");
        }

        if (!self::checkCvv($cvv)) {
            array_push($errors, "Invalid CVV.");
        };
        

        return $errors;
    }

    private function checkName(string $name): bool
    {
        if (!str_contains($name, " ")) {
            return false;
        }

        $splitWords = explode(" ", $name);
        $firstName = $splitWords[0] ?? null;
        $lastName = $splitWords[1] ?? null;


        if (!$firstName && !$lastName) {
            return false;
        }

        if (count($splitWords) > 2) {
            return false;
        }
        
        if (strlen($firstName) < 2 || strlen($lastName) < 2) {
            return false;
        }

        return true;
    }

    private function checkCardNumber(string $cardNumber): bool
    {
        $cardNumber = trim($cardNumber);


        if (strlen($cardNumber) != 16) {
            return false;
        }

        if (!is_numeric($cardNumber)) {
            return false;
        }

        return true;
    }

    private function checkExpiration(string $expiration): bool
    {
        if (!str_contains($expiration, "/")) {
            return false;
        }

        $pairs = explode("/", $expiration);
        $firstPair = $pairs[0] ?? null;
        $secondPair = $pairs[1] ?? null;
        $firstPairInt = intval($firstPair);
        $secondPairInt = intval($secondPair);


        if (!$firstPair && !$secondPair) {
            return false;
        }

        if (!is_numeric($firstPair) && !is_numeric($secondPair)) {
            return false;
        }

        if (strlen($firstPair) < 2 || strlen($secondPair) < 2) {
            return false;
        }

        $pairsMax = $firstPairInt <= 12 && $secondPairInt <= 25;


        if (!$pairsMax) {
            return false;
        }

        if ($firstPair[0] === '0') {
            $firstPairMin = $firstPairInt >= 1;
        } else {
            $firstPairMin = $firstPairInt >= 10;
        }


        $secondPairMin = $secondPairInt >= 22;


        if (!$firstPairMin || !$secondPairMin) {
            return false;
        }

        return true;
    }

    private function checkCvv(string $cvv): bool
    {
        $cvvToInt = intval($cvv);
        if (strlen(trim($cvv)) != 3) {
            return false;
        }

        if (!is_numeric($cvv)) {
            return false;
        }

        if ($cvvToInt % 1000 != $cvvToInt) {
            return false;
        }

        return true;
    }
}
