<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $name = $request['name'];
        $cardNumber = $request['cardNumber'];
        $expiration = $request['expiration'];
        $cvv = $request['cvv'];

        return array_merge(
            $this->validateName($name),
            $this->validateCardNumber($cardNumber),
            $this->validateExpiration($expiration),
            $this->validateCvv($cvv),
        );
    }

    public function validateName($name):array{
        $errors = array();
        $arr = explode(" ",$name);
        if (count($arr) != 2){
            $errors[] = 'name не состоит их 2-х слов';
        }
        if (strlen($arr[0] ) < 2 || strlen($arr[1] ) < 2){
            $errors[] = 'минимальная длина слова - 2 символа';
        }
        return $errors;
    }
    public function  validateCardNumber($cardNumber):array{
        if (strlen($cardNumber) != 16 || !is_numeric($cardNumber)){
            return ['номер карты должен содержать из 16 цифр'];
        }
        return [];
    }
    public function validateExpiration($expiration):array{
        $errors = array();
        if(str_contains($expiration,'/')){
            $arr = explode('/',$expiration);

            if(count(explode('/',$expiration)) != 2 ){
                if (str_len($arr[0]) != 2 || str_len($arr[1]) != 2){
                    return ['формат срока действия должен быть {число}{число}/{число}{число}'];
                }
                if(intval($arr[0]< 1 || intval($arr[0] > 12))){
                   $errors[] = 'минимальное значение для первых пар чисел - 01, максимальное значение для первых пар чисел - 12,';
                }
                if(intval($arr[1] > 25)){
                    $errors[] = $errors[] = 'максимальное значение для вторых пар чисел - 25';
                }
                return $errors;
            }
        }
        return [];
    }
    public function validateCvv($cvv) :array{
        if (!is_numeric($cvv) || strlen($cvv) != 3){
            return ["cvv не трехзначное число"];
        }
        return [];
    }
}