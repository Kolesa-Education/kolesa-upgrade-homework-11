<?php

declare(strict_types=1);

namespace App\Validation;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidator extends TestCase
{
    public function validate(array $request): array
    {
        $errorArray = []
        // here must be the validation of request
        // Array Passed
        // validation rules

        $name = $request['name']
        $card = $request['cardnumber']
        $exp = $request['expiration']
        $cvv = $request['cvv']

        $checkName = checkName($name)
        if($checkName == -1){
            array_push($errorArray,'name is not string format');
        }elseif($checkName != 2){
            array_push($errorArray,'name has wrong format');

        }else{
            array_push($errorArray,'');
            $this->assert_equal(2, $checkName)
        }



        $checkCard = checkCard($card)
        if($checkCard == -1){
            array_push($errorArray,'card is not numeric format');
        }elseif($checkCard != 12){
            array_push($errorArray,'card has wrong format');
        }else{
            array_push($errorArray,'');
            $this->assert_equal(12, $checkName)
        }
  
        $checkExp = checkExpiration($exp)
        if($checkExp == -1){
            array_push($errorArray,'expiration has wrong format');
        }elseif($checkExp == 0){
            array_push($errorArray,'');
            $this->assert_equal(0, $checkExp)
        }


        $checkCvv = checkCvv($cvv)
        if($checkCvv == -1){
            array_push($errorArray,'Cvv has wrong format');
        }elseif($checkCvv == 0){
            array_push($errorArray,'');
            $this->assert_equal(0, $checkCvv)
        }


        return $errorArray

    }

    private function checkName(string $name)  //dont know
    {

        // Check String
        if (!is_string($name)) {
            return -1;
        }
        // remove white space before and after a string
        $name = trim($name);
        
        $sarray = explode(" ", $name); // breakdown string into smaller array of string based on space 
        $len = sizeof($sarray)
         // check for 2 words
        return $len

    }

    private function checkCard(string $card) //dont know
    {
        // Check numeric
        if (!is_numeric($card)) {
            return -1;
        }
        //
        $len = strlen($card)
        return $len
    }

    private function checkExpiration(string $exp)
    {

        $len = strlen($exp)
        if($len != 5){
            return -1;
        }else{
        try{
        $flag = False
        // conversion
        $str1 = substr($exp, 0, 2);
        $str2 = substr($exp, -2);
        //Minimum check
        $str01 = substr($exp, 0, 1);
        $str02 = substr($exp, -2, 1);
        if($str01=="0"){
            $num01 = (int)substr($exp, 1, 1);
            if($num01>=1){
                $flag = True
            }else{
                $flag = False
            }
        }else{
            $num1 = (int)$str1;
            if($num1 <=12 ){
                $flag = True
            }else{
                $flag = False
            }
        }
        
        if($flag){
            $num2 = (int)$str1;
            if($num2<=25 && $num2>=22){
                return 0
            }else{
                return -1
            }
        }else{
            return -1
        }
        



        }
        }catch (Exception $e) {
            return -1;
        }

    }

    private function checkCVV(string $cvv)
    {
        $len = strlen($cvv)
        if($len == 3){
            $str1 = substr($cvv, 0, 1);
            if($str1 == "0"){
                $str2 = substr($cvv, 1, 2);
                if(is_numeric($str2)){
                    return 0
                }else{
                    return -1
                }
            }else{
                if(is_numeric($cvv)){
                    return 0
                }else{
                    return -1
                } 
            }
            
        }else{
            return -1
        }

    }





}