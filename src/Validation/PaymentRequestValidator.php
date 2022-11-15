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
            array_push($errors, "Имя и фамилия указаны некорректно.");
        }

        if (!self::checkCardNumber($cardNumber)) {
            array_push($errors, "Номер карты указан некорректно.");
        }

        if (!self::checkExpiration($expiration)) {
            array_push($errors, "Срок действия карты указан некорректно.");
        }

        if (!self::checkCvv($cvv)) {
            array_push($errors, "CVV код указан некорректно.");
        };
        return $errors;
    }

    private function checkName(string $name): bool
    {
        if (!str_contains($name, " ")) {
            return false;
        }
        $fullName = explode(" ", $name);

        if (!$fullName[0] && !$fullName[1]) {
            return false;
        }

        if (count($fullName) >= 3) {
            return false;
        }

        if (strlen($fullName[0]) < 2 || strlen($fullName[1]) < 2) {
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

        $expDateNumbers = explode("/", $expiration);
        $firstExpDateNumbers = $expDateNumbers[0] ?? null;
        $secondExpDateNumbers = $expDateNumbers[1] ?? null;
        $firstExpDateNumbersInt = intval($firstExpDateNumbers);
        $secondExpDateNumbersInt = intval($secondExpDateNumbers);

        if (!$firstExpDateNumbers && !$secondExpDateNumbers) {
            return false;
        }

        if (!is_numeric($firstExpDateNumbers) && !is_numeric($secondExpDateNumbers)) {
            return false;
        }

        if (strlen($firstExpDateNumbers) < 2 || strlen($secondExpDateNumbers) < 2) {
            return false;
        }

        $maxValuesOfExpDateNumbers = $firstExpDateNumbersInt <= 12 && $secondExpDateNumbersInt <= 26;

        if (!$maxValuesOfExpDateNumbers) {
            return false;
        }

        if ($firstExpDateNumbers[0] === '0') {
            $minValueOfFirstExpDateNumbers = $firstExpDateNumbersInt >= 1;
        } else {
            $minValueOfFirstExpDateNumbers = $firstExpDateNumbersInt >= 10;
        }

        $minValueOfSecondExpDateNumbers = $secondExpDateNumbersInt >= 22;

        if (!$minValueOfFirstExpDateNumbers || !$minValueOfSecondExpDateNumbers) {
            return false;
        }
        return true;
    }

    private function checkCvv(string $cvv): bool
    {
        $cvvInt = intval($cvv);
        if (strlen(trim($cvv)) != 3) {
            return false;
        }

        if (!is_numeric($cvv)) {
            return false;
        }

        if ($cvvInt % 1000 != $cvvInt) {
            return false;
        }
        return true;
    }
}