<?php

namespace App\Validation;


class Card
{
    var string $name;
    var string $cardNumber;
    var string $expiration;
    var string $cvv;

    public function __construct(string $name, string $cardNumber, string $expiration, string $cvv){
        $this->name = $name;
        $this->cardNumber = $cardNumber;
        $this->expiration = $expiration;
        $this->cvv = $cvv;
    }

    public function validateName (): array
    {
        $errors = [];
        $nameSplitted = explode(" ", $this->name);
        if (count($nameSplitted) != 2){
            $errors[] = "name не состоит из 2 слов";
            return $errors;
        }
        if (strlen($nameSplitted[0]) < 2 || strlen($nameSplitted[1]) < 2){
            $errors[] = "Имя и фамилия меньше 2 символов";
            return $errors;
        }
        return $errors;
    }

    public function validateCardNumber(): array
    {
        $errors = [];
        $symbols = str_split($this->cardNumber);
        if (count($symbols) != 12) {
            $errors[] = "CardNumber не состоит из 12 символов";
            return $errors;
        }
        foreach ($symbols as $symbol){
            if (!$this->isInt($symbol)){
                $errors[] = "CardNumber содержит не только символы";
                return $errors;
            }
        }
        return $errors;
    }

    public function validateExpiration(): array
    {
        $errors = [];
        $symbols = str_split($this->expiration);
        if (count($symbols) != 5) {
            $errors[] = "Не соответствует количество символов expiration";
            return $errors;
        }
        for ($i = 0; $i < 5; $i++){
            if (!$this->isInt($symbols[$i]) && $i != 2){
                $errors[] = "expiration не в формате 00/00";
                return $errors;
            }
        }
        if ($symbols[2] !== "/"){
            $errors[] = "expiration не разделен с помощью '/'";
            return $errors;
        }
        $month = intval($symbols[0] . $symbols[1]);
        $year = intval($symbols[3] . $symbols[4]);
        if (($month<1 || $month>12) || ($year<22 || $year>25)){
            $errors[] = "Невалидное значение месяца или года expiration";
            return $errors;
        }
        return $errors;
    }

    public function validateCvv(): array
    {
        $errors = [];
        $symbols = str_split($this->cvv);
        if (count($symbols) != 3){
            $errors[] = "CVV должен состоять из 3 цифр";
            return $errors;
        }
        foreach ($symbols as $symbol){
            if (!$this->isInt($symbol)){
                $errors[] = "CVV должен состоять из 3 цифр";
                return $errors;
            }
        }
        return $errors;
    }

    protected function isInt($string): bool
    {
        if (intval($string) != $string){
            return false;
        } else {
            return true;
        }
    }

}