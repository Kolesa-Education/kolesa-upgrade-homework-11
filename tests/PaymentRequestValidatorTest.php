<?php

use App\Validation\PaymentRequestValidator;
use function PHPUnit\Framework\assertEquals;

class PaymentRequestValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testAllWrong(): void
    {
        $wrong = [
            "name" => "a b",
            "cardNumber" => "1346",
            "expiration" => "15/79",
            "cvv" => "5464"
        ];

        $want = [
            "name: Невалидное имя",
            "cardNumber: состоит из 16 цифр",
            "expiration: невалидное значение",
            "cvv: не 3-ч значное число"];


        $validator=new PaymentRequestValidator();

        $test=$validator->validate($wrong);

        $this>assertEquals($want,$test);


    }
    public function testAllCorrect(){
        $correct = [
            "name" => "Zairakhunov Dilmurat",
            "cardNumber" => "1234567891123456",
            "expiration" => "12/24",
            "cvv" => "012"
        ];

        $want = [];

        $validator=new PaymentRequestValidator();

        $test=$validator->validate($correct);

        $this>assertEquals($want,$test);
    }

    public function testWrongName(){
        $rty=[
            "name" => "Болат Болатбеков Болатович",
            "cardNumber" => "1234123412341234",
            "expiration" => "01/24",
            "cvv" => "014"
        ];

        $want=[
            "name: Невалидное имя",
        ];

        $validator=new PaymentRequestValidator();

        $test=$validator->validate($rty);

        $this>assertEquals($want,$test);
    }
    public function testWrongCard(){
        $rty=[
            "name" => "Болат Болатбеков",
            "cardNumber" => "123412341234123",
            "expiration" => "01/24",
            "cvv" => "014"
        ];

        $want=[
            "cardNumber: состоит из 16 цифр" ,
        ];

        $validator=new PaymentRequestValidator();

        $test=$validator->validate($rty);

        $this>assertEquals($want,$test);
    }
    public function testWrongExp(){
        $rty=[
            "name" => "Болат Болатбеков",
            "cardNumber" => "1234123412341234",
            "expiration" => "01/26",
            "cvv" => "014"
        ];

        $want=[
            "expiration: невалидное значение" ,
        ];

        $validator=new PaymentRequestValidator();

        $test=$validator->validate($rty);

        $this>assertEquals($want,$test);
    }
    public function testWrongCvv(){
        $rty=[
            "name" => "Болат Болатбеков",
            "cardNumber" => "1234123412341234",
            "expiration" => "01/24",
            "cvv" => "0141"
        ];

        $want=[
            "cvv: не 3-ч значное число" ,
        ];

        $validator=new PaymentRequestValidator();

        $test=$validator->validate($rty);

        $this>assertEquals($want,$test);
    }
}