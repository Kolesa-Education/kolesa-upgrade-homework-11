<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        //  здесь должен быть код валидации запроса
        $errs = [];
        $name = $request['name'];
        $cardNumber = $request['cardNumber'];
        $expiration = $request['expiration'];
        $cvv = $request['cvv'];
        $errs[] = $this->validateName($name);
        $errs[] = $this->validateCardNumber($cardNumber);
        $errs[] = $this->validateExpiration($expiration);
        $errs[] = $this->validateCvv($cvv);

        return $errs;
    }

    public function validateName(string $name): string
    {
        $msg = "";
        $fullName = explode(" ", $name);
        if (count($fullName) <2){
            $msg = "Name on card must conteins your full name (name surname)!!!";
        } else if ((strlen($fullName[0] ) < 2) || (strlen($fullName[1]) < 2)){
            $msg = "Name and surname must have at least 2 symbols length!!!";
        }

        return $msg;
    }

    public function validateCardNumber(string $cardNumber): string
    {
        $msg = "";
        $cardNumber = str_replace(" ", "", $cardNumber);
        if (strlen($cardNumber) < 12){
            $msg = "Card number's length must be 12 symbols!!!";
        }

        return $msg;
    }

    public function validateExpiration(string $expiration): array
    {
        $msg = [];
        $expireDate = explode("/", $expiration);
        if (count($expireDate) < 2){
            return ["You must enter expiration in format : month/year!!!"];
        }
        if (($expireDate[0] > 12) || ($expireDate[0] < 1)){
            $msg[] = "Invalid month number in expiration!!!";
        }
        if ($expireDate[0] < 10){
            $monthNumbers = str_split($expireDate[0]);
            if (count($monthNumbers) < 2){
                $msg[] = "Invalid month number in expiration, it must starts with 0 if it lower then 10!!!";
            }
        }
        if (($expireDate[1] > 25) || ($expireDate[1] < 22)){
            $msg[] = "Invalid year number in expiration!!!";
        }

        return $msg;
    }

    public function validateCvv(string $cvv): string
    {
        $msg = "";
        $cvv = str_split($cvv);
        if ((count($cvv) < 3) || (count($cvv) > 3)){
            $msg = "Invalid cvv length!!!";
        } else if (($cvv[1] == 0) || ($cvv[2] == 0)){
            $msg = "Invalid cvv!!!";
        }

        return $msg;
    }
}