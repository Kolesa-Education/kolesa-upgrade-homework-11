<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $errorArr = [];
        $errorArr[] = $this->validateName($request['name']);
        $errorArr[] = $this->validateCardNumber($request['cardNumber']);
        $errorArr[] = $this->validateExpiration($request['expiration']);
        $errorArr[] = $this->validateCvv($request['cvv']);

        return $errorArr;
    }

    function validateName(string $name): string {
        $error = "";
        $nameArr = explode(" ", $name);
        if (count($nameArr) != 2) {
            $error =  "name не состоит их 2-х слов;";
        } else {
            if (strlen($nameArr[0]) < 2 || strlen($nameArr[1]) < 2) {
                $error =  "минимальная длина одного слова - 2 символа;";
            }
        }
        return $error;
    }
    
    function validateCardNumber(string $cardNumber): string {
        $error = "";
        if (strlen($cardNumber) != 12 || !is_numeric($cardNumber)) {
            $error = "cardNumber должен состоять из 12 цифр;";
        }
        return $error;
    }

    function validateExpiration(string $expiration): string {
        $error = "";
        
        $expirationArr = explode("/", $expiration);
        if (count($expirationArr) != 2) {
            return "напишите expiration формате {число}{число}/{число}{число};";
        } else {
            if (!is_numeric($expirationArr[0]) || !is_numeric($expirationArr[1]) || strlen($expirationArr[0]) != 2 || strlen($expirationArr[1]) != 2) {
                return "напишите expiration формате {число}{число}/{число}{число};";
            }
            $expMonth = (int)$expirationArr[0];
            $expYear = (int)$expirationArr[1];
            if ($expMonth > 12 || $expMonth < 1) {
                return "максимальные и минимальные значения для expMonth: 01 и 12;";
            }
            if ($expYear > 25 || $expYear < 22) {
                return "максимальные и минимальные значения для expYear: 22 и 25;";
            }
        }
        return $error;
    }

    function validateCvv(string $cvv): string {
        $error = "";
        if (!is_numeric($cvv) || strlen($cvv) != 3) {
            $error = "cvv должен состоять из 3 цифр;";
        }
        return $error;
    }
}
