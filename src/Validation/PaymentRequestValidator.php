<?php

declare(strict_types=1);

namespace App\Validation;


class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $name = $request["name"] ?? null;
        $cardNumber = $request["cardNumber"] ?? null;
        $expiration = $request["expiration"] ?? null;
        $cvv = $request["cvv"] ?? null;

        $result = [];

        if (!$this->nameFormat($name)) {
            $result[] = "name: Невалидное имя";
        }
        if (!$this->cardFormat($cardNumber)) {
            $result[] = "cardNumber: состоит из 16 цифр";
        }
        if (!$this->expirationFornat($expiration)) {
            $result[] = "expiration: невалидное значение";
        }
        if (!$this->cvvFormat($cvv)) {
            $result[] = "cvv: не 3-ч значное число";
        }
        return $result;
    }

    private function cardFormat($cardNumber): bool
    {
        if (strlen(trim($cardNumber)) != 16) {
            return false;
        }
        return true;
    }

    private function nameFormat($name)
    {
        $name = explode(" ", $name);

        if (count($name) != 2 || strlen($name[0]) < 2 || strlen($name[1]) < 2) {
            return false;
        }
        return true;
    }

    private function expirationFornat($expiration): bool
    {
        if (strlen($expiration) != 5) {
            return false;
        }

        $expiration = explode("/", $expiration);

        if (intval($expiration[0]) >12 || intval($expiration[1]) >25) {
            return false;
        }
        return true;
    }

    private function cvvFormat($cvv)
    {
        if (strlen($cvv) > 3) {
            return false;
        }
        return true;
    }
}