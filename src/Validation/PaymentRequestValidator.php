<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array 
    {
        $errors = array();
        $name=explode(" ", $request['name']);
        $nameCount=count($name);
        $cardNumber=$request['cardNumber'];
        $exp=$request['expiration'];
        $cvv=$request['cvv'];
        if(!$this->checkCountName($nameCount)){
            array_push($errors, "name должен состоять 2-х слов");
        }
        if(!$this->checkName($name)){
            array_push($errors, "Имя и фамилия должны быть минимально из двух букв");
        }
        if(!$this->checkCardNumber($cardNumber)){
            array_push($errors, "card number должен быть из 12 цифр");
        }
        if(!$this->checkexpiration($exp)){
            array_push($errors, "Срок истечения срока не введен корректно");
        }
        if(!$this->checkcvv($cvv)){
            array_push($errors, "cvv должен состоять из 3 цифр");
        }
        return $errors;
    }

    public function checkName(array $name): bool
    {
        if (iconv_strlen($name['0'])>=2 || iconv_strlen($name['1'])>=2)
        {
            return true;
        } else{
            return false;
        }
    }

    public function checkCountName(int $nameCount): bool
    {
        if ($nameCount==2)
        {
            return true;
        } else{
            return false;
        }        
    }

    public function checkCardNumber(string $cardNumber): bool
    {
        if (is_numeric($cardNumber) && iconv_strlen($cardNumber)==12){
            return true;
        } else{
            return false;
        }
    }

    public function checkexpiration(string $exp): bool
    {
        if ($exp[2]=="/" && ((int)substr($exp,0,3)<=12 && (int)substr($exp,0,3)>=1)  && ((int)substr($exp,3,7)<=25 && (int)substr($exp,3,7)>=22)){
            return true;
        } else{
            return false;
        }
    }

    public function checkcvv(string $cvv): bool
    {
        if (is_numeric($cvv) && iconv_strlen($cvv)==3){
            return true;
        } else{
            return false;
        }
    }
}