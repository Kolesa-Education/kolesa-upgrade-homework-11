<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    public function validate(array $request): array
    {
        // prepare data for test 
         $err_msg = [];
         
         $name = $request['name'];  // array of FirstName, LastName and LastName
         
         $err  = $this->testName($name);
         if (count($err)!=0){
            $err_msg =array_merge($err_msg,$err);
         }
       
         $cardNumber = $request['cardNumber'];
         str_replace(" ", "", $cardNumber);

         $err  = $this->testCard($cardNumber);
         if (count($err)!=0){
            $err_msg =array_merge($err_msg,$err);
         }
         
         $expiration = $request['expiration'];
         
         $err  = $this->testExpiration($expiration);
         if (count($err)!=0){
            $err_msg =array_merge($err_msg,$err);
         }

         $cvv = $request['cvv'];
         $err  = $this->testCVV($cvv);
         if (count($err)!=0){
            $err_msg =array_merge($err_msg,$err);
         }
         return $err_msg;
    }
    public function testName( array $name):array {
        $err = [];
        if (count($name) != 2){
            array_push($err, "Error->name: Number of arguments");    
        }    
        foreach ($name as $value) {
            if(count($value) < 2){
                array_push($err, "Error->name: Length of arguments");    
            }
            if (!preg_match('/[^a-zA-Z]/', $value)){
                array_push($err, "Error->name: string contains invalid characters");   
            }
        }
        return $err;
    }
    public function testCard( string $card):array {
       $err = [];
       if (strlen($card) != 12){
        array_push($err, "Error->cardNumber: Number of digits");    
       }
       if(!ctype_digit($card)){
        array_push($err, "Error->cardNumber: Contains not only digits");    
       }
       return $err;
    }
    public function testExpiration(string $expiration):array{
        $err = [];
        if (str_contains($expiration, '/')) {
            array_push($err, "Error->expiration: Number of digits");    
        }
        $expiration = explode("/",$expiration);
        if (count($expiration) != 2){
            array_push($err, "Error->expiration: Number of digits");    
        }

        if ($expiration[0] >= 1 && $expiration[0] <= 12 && $expiration[1] >= 22 && $expiration[1] <= 25){
            array_push($err, "Error->expiration: digits out of range");    
        }
        return $err;
    }

    public function testCVV( string $cvv):array {
        $err = [];
        if (strlen($cvv) != 3){
         array_push($err, "Error->CVV: Number of digits");    
        }
        if(!ctype_digit($cvv)){
         array_push($err, "Error->CVV: Contains not only digits");    
        }
        return $err;
    }
}
  
