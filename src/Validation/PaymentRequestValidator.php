<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    const COUNT_NAME_WORDS = 2;
    const MIN_WORD_LEN = 2;
    const NAME_COUNT_ERROR = 'name не состоит из' . self::COUNT_NAME_WORDS . '-х слов';
    const NAME_WORD_LEN_ERROR = 'длина составляющих name меньше' .  self::MIN_WORD_LEN . '-х символов';
    const NOT_DIGIT_ERROR = 'номер карты состоит не только из цифр';
    const CARD_NUMBER_LEN_ERROR = 'номер карты не 12 символов';
    const EXPIRATION_FORMAT_ERROR = 'формат expiration не соответствует шаблону';
    const EXPIRATION_DIGITS_ERROR = 'числа в expiration не состоят из 2-х цифр';
    const FIRST_DIGIT_ERROR = 'первое число в expiration указано неправильно';
    const SECOND_DIGIT_ERROR = 'второе число в expiration указано неправильно';
    const CVV_ERROR = 'cvv не состоит из 3-х чисел';


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
            $result[] = self::NAME_COUNT_ERROR;
        }

        if (strlen($words[0]) < self::MIN_WORD_LEN || strlen($words[1]) < self::MIN_WORD_LEN) {
            $result[] = self::NAME_WORD_LEN_ERROR;
        }

        return $result;
    }

    public function validateCardNumber(string $cardNumber): array
    {
        $result = [];

        if (!is_numeric($cardNumber)) {
            $result[] = self::NOT_DIGIT_ERROR;
        }

        if (strlen($cardNumber) !== 12) {
            $result[] = self::CARD_NUMBER_LEN_ERROR;
        }

        return $result;
    }

    public function validateExpirationDate(string $date): array 
    {
        $result = [];

        $pattern = "[^0-9][^0-9]/[^0-9][^0-9]";

        if (!preg_match($pattern, $date)) {
            $result[] = self::EXPIRATION_FORMAT_ERROR;
        }

        $digits = explode("/", $date);

        if (strlen($digits[0]) !== 2 || strlen($digits[1]) !== 2) {
            $result[] = self::EXPIRATION_DIGITS_ERROR;
        }

        if ($digits[0] > 12 || $digits[0] < 1) {
            $result[] = self::FIRST_DIGIT_ERROR;
        }

        if ($digits[1] > 25 || $digits[1] < 22) {
            $result[] = self::SECOND_DIGIT_ERROR; 
        }

        return $result;
    }

    public function validateCard(string $cardNumber, $expiration, $cvv): array
    {
        $result = array_merge($this->validateCardNumber($cardNumber), $this->validateExpirationDate($expiration));

        if (strlen($cvv) !== 3) {
            array_merge($result, [self::CVV_ERROR]);
        }

        return $result;
    }
}