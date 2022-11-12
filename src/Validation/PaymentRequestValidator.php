<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    { 
        $errors = array(); 

        $nameErrs= $this->validateName($request['name']);
        if( !empty($nameErrs) ){
            $errors=array_merge($errors,$nameErrs);
        }

        $cardErrs= $this->validateCardNumber($request['cardNumber']);
        if( !empty($cardErrs) ){
            $errors=array_merge($errors,$cardErrs);
        }

        $expErrs= $this->validateExpiration($request['expiration']);
        if( !empty($expErrs) ){
            $errors=array_merge($errors,$expErrs);
        }

        $cvvErrs= $this->validateCvv($request['cvv']);
        if( !empty($cvvErrs) ){
            $errors=array_merge($errors,$cvvErrs);
        }
        

        return $errors;

    }

    private function validateName(string $name):array{
        // ideas : no digits, no longer than 100 
        $errors = array();

        $words = explode(" ",$name);
        if(count($words) != 2 ){
            array_push($errors, 'NAME ERROR: Имя состоит не из 2 слов');
            return $errors;
        }

        if (strlen($words[0])< 2 || strlen($words[1])<2){
            array_push($errors, 'NAME ERROR: Слова состоят меньше, чем из 2 символов');
        }
        if (preg_match('~[0-9]+~', $words[0]) || preg_match('~[0-9]+~', $words[1])) {
            array_push($errors, 'NAME ERROR: Имя не должно содержать цифры');
        }
        if (!preg_match('/^[A-ZА-Я]/u', $words[0]) || !preg_match('/^[A-ZА-Я]/u', $words[1])) {
            array_push($errors, 'NAME ERROR: Имя и Фамилиия должны быть написаны с заглавной буквы');
        }
        

        return $errors;

    }
    private function validateCardNumber(string $number):array{
        $errors = array();
        
        if(strlen($number) !=12){
           array_push($errors, 'CARDNUMBER ERROR: Строка не состоит из 12 символов');
           return $errors;
        }

        $pattern = "/\d{12}/";
        if(!preg_match($pattern, $number)){
            array_push($errors, 'CARDNUMBER ERROR: Строка не состоит из 12 цифр');
        }


        
        return $errors;

    }

    private function validateExpiration(string $date) : array{
        $errors = array();
        if(strlen($date) !=5){
            array_push($errors, 'EXPIRATION ERROR: Строка не состоит из 5 символов');
            return $errors;
         }
 
         $pattern = "/\d{2}\/\d{2}/";
         if(!preg_match($pattern, $date)){
            array_push($errors, 'EXPIRATION ERROR: Строка не состоит из 4 цифр и делителя ');
            return $errors;
         }

         $num1 = intval(substr($date,0,2));
         $num2 = intval(substr($date,3,2));
         if($num1<1 || $num1 >12){
            array_push($errors, 'EXPIRATION ERROR: Первое число должно быть меньше 12 и больше 1');
         }
         if($num2<22 || $num2 >25){
            array_push($errors, 'EXPIRATION ERROR:Второе число должно быть меньше 25 и больше 22');
         }
         
        return $errors;


    }
    private function validateCvv(string $number) : array{

        $errors = array();
        
        if(strlen($number) !=3){
           array_push($errors, 'CVV ERROR: Строка не состоит из 3 символов');
           return $errors;
        }

        $pattern = "/\d{3}/";
        if(!preg_match($pattern, $number)){
            array_push($errors, 'CVV ERROR: Строка не состоит из 3 цифр');
        }
        else if( !intval(substr($number,1,1)) || !intval(substr($number,2,1)) ){
            array_push($errors, 'CVV ERROR: Ваш CVV недостаточно надежен и содержит большое количество нулей');
        }


        return $errors;
    }

}