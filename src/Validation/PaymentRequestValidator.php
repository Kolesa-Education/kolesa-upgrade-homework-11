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
        str_replace(" ", "", $cardNumber);
        $expiration = $request['expiration'];
        $cvv = $request['cvv'];

        $fullName = explode(" ", $name);
        if (count($fullName) <2){
            $msg = "Name on card must conteins your full name (name surname)!!!";
            $errs[] = $msg;
        }

        if (strlen($cardNumber) < 12){
            $msg = "Card number's length must be 12 symbols!!!";
            $errs[] = $msg;
        }

        $expireDate = explode("/", $expiration);
        if (count($expireDate) < 2){
            $msg = "You must enter expiration in format : month/year!!!";
            $errs[] = $msg;
        } else if (($expireDate[0] > 12) || ($expireDate < 1)){
            $msg = "Invalid month number in expiration!!!";
            $errs[] = $msg;
        } else if ($expireDate[0] < 10){
            $monthNumbers = explode("", $expireDate[0]);
            if (count($monthNumbers) < 2){
                $msg = "Invalid month number in expiration, it must starts with 0 if it lower then 10!!!";
                $errs[] = $msg;
            }
        } else if (($expireDate[1] > 25) || ($expireDate < 22)){
            $msg = "Invalid year number in expiration!!!";
            $errs[] = $msg;
        }

        $cvv = str_split($cvv);
        if ((count($cvv) < 3) || (count($cvv) > 3)){
            $msg = "Invalid cvv length!!!";
            $errs[] = $msg;
        } else if (($cvv[1] == 0) || ($cvv[2] == 0)){
            $msg = "Invalid cvv!!!";
            $errs[] = $msg;
        }

        return $errs;
    }
}