<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $errors = array();
        // Make requests for every parameter that we need to check
        $name = $request['name'];
        $cardNumber = $request['cardNumber'];
        $expiration = $request['expiration'];
        $cvv = $request['cvv'];

        if (!$this->isConsistedOfTwoWords($name)){
            array_push($errors, $name . "не состоит их 2-х слов!");
        }

        if(!$this->isMoreThanTwoSymbols($name)){
            array_push($errors, $name . " содержит меньше двух символов в имени или/и фамилии!");
        }

        if (!$this->isCardLengthEqualTo12($cardNumber)){
            array_push($errors, $cardNumber . " не 12-значное число!");
        }

        if (!$this->isValidExpiration($expiration)){
            array_push($errors, $expiration . " not valid!");
        }

        if (!$this->isCvvThreeDigit($cvv)){
            array_push($errors, $cvv . " not three digit!");
        }

        return $errors;
    }

    public function isConsistedOfTwoWords(string $name): bool
    {
        $delimiter = ' ';
        $words = explode($delimiter, $name);
        return count($words) == 2;
    }

    public function isMoreThanTwoSymbols(string $name): bool
    {
        $delimiter = ' ';
        $words = explode($delimiter, $name);
        return strlen($words[0]) >= 2 && strlen($words[1]) >= 2;
    }


    public function isCardLengthEqualTo12(string $cardNumber): bool
    {
        return strlen($cardNumber) == 12;
    }

    public function isValidExpiration(string $expiration): bool
    {
        $delimiter = "/";
        $expirationDates = explode($delimiter, $expiration);
        $month = intval($expirationDates[0][0] . $expirationDates[0][1]);
        $year = intval($expirationDates[1][0] . $expirationDates[1][1]);

        return count($expirationDates) == 2 && $month >= 1 && $month <= 12 && $year >= 22 && $year <= 25;
    }

    public function isCvvThreeDigit(string $cvv):bool{
        return strlen($cvv) == 3 && intval($cvv) > 0 && $cvv[1] != "0" && cvv[2] != "0";
    }

}