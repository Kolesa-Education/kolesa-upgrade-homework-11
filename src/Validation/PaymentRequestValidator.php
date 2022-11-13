<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $nameErrors = $this->validateName($request['name']);
        $cardNumberErrors = $this->validateCardNumber($request['cardNumber']);
        $expirationErrors = $this->validateExpiration($request['expiration']);
        $cvvErrors = $this->validateCVV($request['cvv']);

        $errors = array_merge($nameErrors, $cardNumberErrors, $expirationErrors, $cvvErrors);

        return $errors;
    }

    private function validateName(string $name) : array
    {
        $errors = [];
        $arr = explode( " " , $name);

        if(count($arr) != 2){
            $errors[] = 'name не состоит их 2-х слов';
            return $errors;
        }

        if(strlen($arr[0]) < 2 || strlen($arr[1]) < 2){
            $errors[] = 'Минимальная длина имен/фамилии 2 символа';
        }

        return $errors;
    }

    private function validateCardNumber(string $num) : array 
    {
        $errors = [];

        if(strlen($num) != 12){
            $errors[] = "Длина номера карты должно быть 12";
        }

        if(!ctype_digit($num)){
            $errors[] = "Номер карты должен состоять из цифр";
        }

        return $errors;
    }

    private function validateExpiration(string $exp) : array 
    {
        $errors = [];

        $arr = explode( "/" , $exp);

        if(count($arr) != 2){
            $errors[] = "В дате истечении не две строки разделенных /";
            return $errors;
        }

        if(strlen($arr[0]) != 2){
            $errors[] = "В месяце истечения больше двух символов";
        }

        if(strlen($arr[1]) != 2){
            $errors[] = "В годе истечения больше двух символов";
        }

        if(!ctype_digit($arr[0]) || !ctype_digit($arr[1])){
            $errors[] = "Дата должна состоять из цифр";
            return $errors;
        }

        $month = (int) $arr[0];
        $year = (int) $arr[1];

        if($month < 0 || $month > 12){
            $errors[] = "Месяц не в range [0,12]";
        }

        if($year < 22 || $year > 25){
            $errors[] = "Год не в range [22,25]";
        }

        return $errors;
    }

    private function validateCVV(string $cvv) : array {
        $errors = [];

        if(strlen($cvv) != 3){
            $errors[] = "cvv не трехзначное число";
        }

        if(!ctype_digit($cvv)){
            $errors[] = "CVV должен состоять из цифр";
        }

        return $errors;
    }
}
