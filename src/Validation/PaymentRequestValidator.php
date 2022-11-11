<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        //  здесь должен быть код валидации запроса
        $errs = array();

        $name = $request['name'];
        $name = trim($name);


        $cardNumber = $request['cardNumber'];
        $expiration = $request['expiration'];
        $cvv = $request['cvv'];

        if (!$this->isTwoWords($name)){
            array_push($errs,"name не состоит их 2-х слов!");
        }

        if(!$this->isMoreTwoSymb($name)){
            array_push($errs,"name- Имя или фамилия содержит только один символ!");
        }

        if (!$this->isValidCardLength($cardNumber)){
            array_push($errs,"cardNumber не состоит из 12 цифр!");
        }

        if (!$this->isValidExpiration($expiration)){
            array_push($errs,"expiration невалидный!");
        }

        if (!$this->isThirdNumberCvv($cvv)){
            array_push($errs, "cvv не трехзначное число!");
        }

        if (!$this->isFirstCvvZero($cvv)){
            array_push($errs,"cvv - второй или третий символ 0!");
        }

        return $errs;
    }

    public function isTwoWords(string $name): bool
    {
        $arrName = explode(" ", $name);
        if (count($arrName) == 2) {
            return true;
        }
        return false;
    }

    public function isMoreTwoSymb(string $name): bool
    {
        $arrName = explode(" ", $name);
        if (strlen($arrName[0]) > 1 && strlen($arrName[1]) > 1) {
            return true;
        }
        return false;
    }

    public function isValidCardLength(string $cardNumber): bool
    {
        if (strlen($cardNumber) == 12) {
            return true;
        }
        return false;
    }

    public function isValidExpiration(string $expiration): bool
    {
        $arr = explode("/",$expiration);

        if (count($arr) != 2){
            return false;
        }

        if ($arr[0] >= 1 && $arr[0] <= 12 && $arr[1] >= 22 && $arr[1] <= 25){
            return true;
        }

        return false;
    }

    public function isThirdNumberCvv(string $cvv):bool{
        if (strlen($cvv) != 3){
            return false;
        }

        foreach (str_split($cvv) as $ch) {
            if (!is_numeric($ch)) {
                return false;
            }
        }

        return true;
    }

    public function isFirstCvvZero(string $cvv):bool{
        if ($cvv[1] == "0" || $cvv[2] == "0"){
            return false;
        }
        return true;
    }

}