<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        //  здесь должен быть код валидации запроса
        $nameErr = $this->valName($request['name']);
        $cardNumErr = $this->valCardnum($request['cardNumber']);
        $expirErr = $this->valExpir($request['expiration']);
        $cvvErr = $this->valCvv($request['cvv']);
        $errors[] = array_merge($nameErr, $cardNumErr, $expirErr, $cvvErr);

        return $errors;
    }

    public function valName(string $name) : array
    {
        $errors = [];
        if (strlen($name) != 2){
            $errors[] = "минимальная длина слова - 2 символа";
        }

        return $errors;
    }

    public function valCardnum(string $cardNumber) : array 
    {
        $errors = [];
        if (strlen($cardNumber) != 12){
            $errors[] = "cardNumber должен состоять из 12 цифр";  
        }
        if (!ctype_digit($cardNumber)) {
            $errors[] = "ты не ввел число"; 
        }
        return $errors;
    }

    public function valExpir(string $expiration) : array
    {
        $errors = [];
        $asd = explode( "/" , $expiration);
        if (strlen($asd) != 2){
            $errors[] = "строка формата {число}{число}/{число}{число}";
        }
        $parsedInt1 = intval($asd[0]);
        if ($parsedInt1 <= 12){
            $errors[] = "максимальное значение для первых пар чисел - 12";
        }
        $parsedInt2 = intval($asd[1]);
        if ($parsedInt2 <= 25){
            $errors[] = "для вторых - 25";
        }
        if ($parsedInt2){
            $errors[] = "для вторых - 22";
        }

        return $errors;
        //поидее на фронте можно было бы выборку даты поставить и не пришлось бы заморачиватся
    }
 
    public function valCvv(string $cvv) : array
    {
        $errors = [];
        if (!ctype_digit($cvv)) {
            $errors[] = "ты не ввел число"; 
        }
        if (strlen($cvv) != 3){
            $errors[] = "cvv должен состоять из 3 цифр";
        }
        return $errors;
    }
}