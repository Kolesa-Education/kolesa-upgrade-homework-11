<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        // $name_arr = explode(" ", $request["name"]);
        // $name_count = count($name_arr);
        // $cardNum = $request["cardNumber"];
        // $cvv = $request["cvv"];
        // $exp = $request["expiration"];
        $err = [];

        return array_merge(
            $this->nameLength($request),
            $this->nameCount($request),
            $this->cardNumLength($request),
            $this->expirationCheck($request),
            $this->cvvCheck($request)
        );
    }

    public function nameCount(array $request): array {
        $name_arr = explode(" ", $request["name"]);
        $name_count = count($name_arr);

        if ($name_count !== 2) {
            array_push($err, "Неверный формат, введите имя и фамилию через пробел");
        }
        return [];
    }

    public function nameLength(array $request): array {
        $name_arr = explode(" ", $request["name"]);
        $firstName = $name_arr[0];
        $secondName = $name_arr[1];

        if (strlen($firstName) < 2 || (strlen($secondName) < 2)) {
            array_push($err, "Имя и фамилия должная состоять минимум из 2-х букв");
        }
        if (is_numeric($firstName) || (is_numeric($secondName))) {
            array_push($err, "Имя и фамилия не должны содержать чисела");
        }
        return [];
    }

    public function cardNumLength(array $request): array {
        $cardNum = $request["cardNumber"];

        if (!is_numeric($cardNum) || (strlen($cardNum)) !== 12) {
            array_push($err, "Неверный формат, введите номер карты состоящий из 12 символов");
        }
        return [];
    }

    public function expirationCheck(array $request): array{
        $exp = $request["expiration"];

        if (str_contains($exp, "/")) {
            $exp_arr = explode("/", $exp);
            if (count($exp_arr) == 2 && strlen($exp_arr[0]) == 2 && strlen($exp_arr[1]) == 2) {
                if (((int)$exp_arr[0] >= 1 || intval($exp_arr[0]) <= 12) && (intval($exp_arr[1]) >= 22 || intval($exp_arr[1]) <= 25)) {
                    return [];
                }
                return array_push($err, "Неверно заданы числа, пример ввода 01/23 ");
            }
            return array_push($err, "Неверно заданы числа, пример ввода 01/23 ");
        }
        return array_push($err, "Введите месяц и год, разделенные знаком / ");
    }
    
    public function cvvCheck(array $request): array {
        $cvv = $request["cvv"];
        $cvvNum = intval($cvv);

        if (strlen((string)$cvvNum) < 3 || strlen((string)$cvvNum) > 3){
            array_push($err, "CVV код должен состоять из 3-х цифр");
        }
        return [];
    }
}