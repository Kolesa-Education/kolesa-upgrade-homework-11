<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    const COUNT_NAME_WORDS = 2;
    const MIN_WORD_LEN = 2;
    const CARD_LEN = 12;
    const CVV_LEN = 3;

    public function validate(array $request): array
    {
        $result = array_merge(
            $this->validateName($request['name']), 
            $this->validateCard($request['cardNumber'], 
            $request['expiration'], $request['cvv'])
        );

        return $result;
    }

    public function validateName(string $name): array 
    {
        $result = [];
        $words = explode(" ", $name);
        
        if (count($words) !== self::COUNT_NAME_WORDS) {
            $result[] = 'name не состоит их 2-х слов';
        }

        if (strlen($words[0]) < self::MIN_WORD_LEN || strlen($words[1]) < self::MIN_WORD_LEN) {
            $result[] = 'длина составляющих name меньше 2-х символов';
        }

        return $result;
    }

    public function validateCardNumber(string $cardNumber): array
    {
        $result = [];

        if (!is_numeric($cardNumber)) {
            $result[] = 'номер карты состоит не только из цифр';
        }

        if (strlen($cardNumber) !== self::CARD_LEN) {
            $result[] = 'номер карты не 12 символов';
        }

        return $result;
    }

    public function validateExpirationDate(string $date): array 
    {
        $result = [];

        $pattern = "[^0-9][^0-9]/[^0-9][^0-9]";

        if (!preg_match($pattern, $date)) {
            $result[] = 'формат expiration не соответствует шаблону';
        }

        $digits = explode("/", $date);

        if (strlen($digits[0]) !== 2 || strlen($digits[1]) !== 2) {
            $result[] = 'числа в expiration не состоят из 2-х цифр';
        }

        if ($digits[0] > 12 || $digits[0] < 1) {
            $result[] = 'первое число в expiration указано неправильно';
        }

        if ($digits[1] > 25 || $digits[1] < 22) {
            $result[] = 'второе число в expiration указано неправильно'; 
        }

        return $result;
    }

    public function validateCard(string $cardNumber, $expiration, $cvv): array
    {
        $result = array_merge($this->validateCardNumber($cardNumber), $this->validateExpirationDate($expiration));

        if (strlen($cvv) !== 3) {
            array_merge($result, ['cvv не состоит из 3-х чисел']);
        }

        return $result;
    }
}