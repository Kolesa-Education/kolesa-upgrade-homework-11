<?php

declare(strict_types=1);

namespace App\Validation;
use PHPUnit\Framework\TestCase;
use Exception;
require_once 'vendor/autoload.php';
class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        $errors = array();
        $number = $request["cardNumber"];
        $cvv = $request["cvv"];
        $expiration = $request["expiration"];
        $n_arr = explode(" ",$request["name"]);
        $name_count = count($n_arr);
        if (!$this->isvalidnumber($number)){
            array_push($errors, "Номер не равен 12 цифрам или содержит сторонние символы");
        }

        if(!$this->isvalidexpiredate($expiration))
        {
            array_push($errors, "Дата не соответствует формату");
        };
        if(!$this->isvalidcvv($cvv)){
            array_push($errors, "CVV не равен 3 цифрам или содержит сторонние символы");
        };
        if(!$this->Istwowords($name_count)){
            array_push($errors, "Имя не содержит 2 слова");
        };
        if(!$this->Ismoretwoletters($n_arr)){
            array_push($errors, "Имя или фамилия содержит менее двух букв");

        };
        if(!$this->Iscapwords($request["name"])){
            array_push($errors, "Имя или фамилия написаны не с заглавной буквы");

        };
        return $errors;
    }

    public function isvalidnumber(string $number): bool
    {
        $number = intval($number);
        if (strlen((string)$number)==12){
            return true;
        }
        else{
            
            return false;
        }
    }
    public function isvalidexpiredate(string $expiredate): bool
    {
            if(str_contains($expiredate, '/')){
                $n_arr = explode("/",$expiredate);
                if(count($n_arr)==2 && strlen($n_arr[0])==2 && strlen($n_arr[1])==2){
                    if(((int)$n_arr[0]>=1 || intval($n_arr[0])<=12) && (intval($n_arr[1])>=22 || intval($n_arr[1])<=25)){

                    return true;
                }
                
                return false;
                }
                return false;

            } 
            return false;
}
    public function isvalidcvv(string $number): bool
    {
        $number = intval($number);

        if(strlen((string)$number)==3){
            return true;
        }
        else{
            
            return false;
        }
        
        
        
    }
    public function Istwowords(int $name_count): bool
    {
            if ($name_count==2){
            return true;
            }
            else{
                return false;
            }
    }
    public function Ismoretwoletters(array $name_arr): bool
    {
        $name_count = count($name_arr);
        $i = 0;
        do{
            if(strlen($name_arr[$i])<2){
                return false;
            };
            $i++;
        } while($i<$name_count);
        return true;
    }
    public function Iscapwords(string $name): bool
    {

            if($name==ucwords($name)){
                return true;
            }
            else{
                return false;
            }
            
        
    }
}