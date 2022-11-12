<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    private array $errors;

    public function __construct()
    {
        $this->errors = array();    
    }

    public function validate(array $request): array
    {
        //  здесь должен быть код валидации запроса

        // validate name
        if (!empty($request['name'])){
            $this->validateName($request['name']);
        }else{
            array_push($this->errors, 'name не записан');
        }

        // validate  cardNumber
        if (!empty($request['cardNumber'])){
            $this->validateCardNumber($request['cardNumber']);
        }else{
            array_push($this->errors, 'cardNumber не записан');
        }

        // validate expiration
        if (!empty($request['expiration'])){
            $this->validateExpiration($request['expiration']);
        }else{
            array_push($this->errors, 'expiration не записан');
        }       
        
        // validate cvv
        if (!empty($request['cvv'])){
            $this->validateCvv($request['cvv']);
        }else{
            array_push($this->errors, 'cvv не записан');
        }

        return $this->errors;
    }

    private function validateName(string $name)
    {
        $arrayString = preg_split('/\s+/', $name);

        if (sizeof($arrayString) != 2) {
            array_push($this->errors, 'name не состоит их 2-х слов');
            return;
        }

        foreach($arrayString as $arr){
            if (strlen($arr) < 2) {
                $format = '%s состоит менее чем из двух букв';
                array_push($this->errors, sprintf($format,$arr));
            }
        }
    }

    private function validateCardNumber(string $card)
    {
        if (strlen($card) != 12){
            array_push($this->errors, 'cardNumber не 12-ти значное число');
        }

        if (preg_match('/^(0{12})/', $card)) {
            array_push($this->errors, 'cardNumber состоит только из нуля');
        }

        if (!preg_match('/^\d+$/',$card)) {
            array_push($this->errors, 'cardNumber не состоит только из цифр');
        }
    }

    private function validateExpiration(string $expDate)
    {
        if (!preg_match('/^((0[1-9])|(1[0-2]))\/(2[2-5])$/', $expDate)){
            array_push($this->errors, 'expiration записан в недопустимом формате');
        }
    }

    private function validateCvv(string $cvv)
    {
        if (strlen($cvv) != 3){
            array_push($this->errors, 'cvv не 3-x значное число');
        }

        if (!preg_match('/^\d+$/',$cvv)) {
            array_push($this->errors, 'cvv не состоит только из цифр');
        }
    }
}