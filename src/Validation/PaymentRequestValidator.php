<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $errors = [];
        $nameOnCard = $request['name'];
        $cardNumber = $request['cardNumber'];
        $expiration = $request['expiration'];
        $cvv = $request['cvv'];
        $errors = self::checkName($nameOnCard, $errors);
        $errors = self::checkNumber($cardNumber, $errors);
        $errors = self::checkExpiration($expiration, $errors);
        $errors = self::checkCvvCode($cvv, $errors);

        return $errors;
    }

    private static function checkName(string $nameOnCard, array $err): array
    {
        $nameOnCard = explode(' ', $nameOnCard);
        [$firstName, $secondName] = $nameOnCard;
        if (count($nameOnCard) !== 2) {
            $err[] = 'поле name должно состоять из двух слов';
        }
        if (!ctype_alpha($firstName)) {
            $err[] = 'неверно введено имя, имя должно состоять только из символов латинского алфавита';
        }
        if (!ctype_alpha($secondName)) {
            $err[] = 'неверно введена фамилия, фамилия состоять только из символов латинского алфавита';
        }
        if (count(str_split($firstName)) < 2) {
            $err[] = 'имя должно состоять минимум из двух символов';
        }
        if (count(str_split($secondName)) < 2) {
            $err[] = 'фамилия должна состоять минимум из двух символов';
        };

        return $err;
    }

    public static function checkNumber(string $cardNumber, array $err): array
    {
        $num = str_replace(' ', '', $cardNumber);
        if (!ctype_digit($num)) {
            $err[] = 'код карты должен содержать только цифцы с 0 по 9';
        }
        if (count(str_split($num)) !== 16) {
            $err[] = 'код карты должен состоять из 16 цифр';
        }

        return $err;
    }

    public static function checkExpiration(string $expirationDate, array $err): array
    {
        if (preg_match("/^(0[1-9]|1[0-2])\/?(2[2-5])$/", $expirationDate) === 0) {
            $err[] = 'некорректный формат срока годности карты, корректный формат месяц/год';
        }

        return $err;
    }

    public static function checkCvvCode(string $cvvCode, array $err): array
    {
        if (ctype_digit($cvvCode) === false) {
            $err[] = 'некорректный код cvv, код должен состоять только цифр';
        }
        if (count(str_split($cvvCode)) !== 3) {
            $err[] = 'некорректный код cvv, код должен состоять только из трех цифр';
        }

        return $err;
    }
}