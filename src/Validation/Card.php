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
        $nameSplitted = explode(" ", $this->name);
        if (count($nameSplitted) != 2){
            return ["name не состоит из 2 слов"];
        }
        if (strlen($nameSplitted[0]) < 2 || strlen($nameSplitted[1]) < 2){
            return ["name и фамилия меньше 2 символов"];
        }
        //Костыль для русского языка ctype_alpha() поддерживает только латиницу
        foreach ($nameSplitted as $namePart) {
            foreach (str_split($namePart, 1) as $symbol) {
                if (ctype_punct($symbol) || ctype_digit($symbol)){
                    return ["name содержит недопустимые символы"];
                }
            }
        }
        return [];
    }

    public function validateCardNumber(): array
    {
        $symbols = str_split($this->cardNumber);
        if (count($symbols) != 12) {
            return ["CardNumber не состоит из 12 символов"];
        }
        if (!ctype_digit($this->cardNumber)){
            return ["CardNumber содержит не только символы"];
        }
        if (
            $symbols[0] != 3 && //American Express
            $symbols[0] != 4 && //Visa
            $symbols[0] != 5 && //Mastercard
            $symbols[0] != 6 //Discover Cards
        ){
            return ["CardNumber неизвестной компании"];
        }
        return [];
    }

    public function validateExpiration(): array
    {
        $symbols = str_split($this->expiration);
        if (count($symbols) != 5) {
            return ["Не соответствует количество символов expiration"];
        }
        for ($i = 0; $i < 5; $i++){
            if (!ctype_digit($symbols[$i]) && $i != 2){
                return ["expiration не в формате 00/00"];
            }
        }
        if ($symbols[2] !== "/"){
            return ["expiration не разделен с помощью '/'"];
        }
        $month = intval($symbols[0] . $symbols[1]);
        $year = intval($symbols[3] . $symbols[4]);
        if (($month<1 || $month>12) || ($year<22 || $year>25)){
            return ["Невалидное значение месяца или года expiration"];
        }
        return [];
    }

    public function validateCvv(): array
    {
        $symbols = str_split($this->cvv);
        if (count($symbols) != 3){
            return ["CVV должен состоять из 3 цифр"];
        }
            if (!ctype_digit($this->cvv)){
                return ["CVV должен состоять из 3 цифр"];
            }
        return [];
    }
}