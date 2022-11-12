<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{

    public function testValidate(): void
    {
        $request = [ array('name' => 'A Kochevoy', 'cardNumber' => '544 322 43 127', 'expiration' => '11/12', 'cvv' => '605'),
            [ "Name and surname must have at least 2 symbols length!!!",
                "Card number's length must be 12 symbols!!!",
                ["Invalid year number in expiration!!!"],
                "Invalid cvv!!!"
                ]];
        $validator = new PaymentRequestValidator();
        $actual = $validator->validate($request[0]);
        $this->assertEquals($request[1], $actual);
    }

    public function testValidateName(): void
    {
        $request = [ array('name' => 'A Kochevoy', 'cardNumber' => '544 322 743 127', 'expiration' => '11/22', 'cvv' => '615'),
            [ "Name and surname must have at least 2 symbols length!!!"]];
        $validator = new PaymentRequestValidator();
        $actual = $validator->validateName($request[0]['name']);
        $this->assertEquals($request[1][0], $actual);
    }

    public function testValidateCardNumber(): void
    {
        $request = [ array('name' => 'ALexey Kochevoy', 'cardNumber' => '544 322 743 12', 'expiration' => '11/22', 'cvv' => '615'),
            [ "Card number's length must be 12 symbols!!!"]];
        $validator = new PaymentRequestValidator();
        $actual = $validator->validateCardNumber($request[0]['cardNumber']);
        $this->assertEquals($request[1][0], $actual);
    }

    public function testValidateExpiration(): void
    {
        $request = [ array('name' => 'ALexey Kochevoy', 'cardNumber' => '544 322 743 123', 'expiration' => '1/12', 'cvv' => '615'),
            [ "Invalid month number in expiration, it must starts with 0 if it lower then 10!!!",
                "Invalid year number in expiration!!!"]];
        $validator = new PaymentRequestValidator();
        $actual = $validator->validateExpiration($request[0]['expiration']);
        $this->assertEquals($request[1], $actual);
    }

    public function testValidateCvv(): void
    {
        $request = [ array('name' => 'ALexey Kochevoy', 'cardNumber' => '544 322 743 123', 'expiration' => '11/22', 'cvv' => '15'),
            ["Invalid cvv length!!!"]];
        $validator = new PaymentRequestValidator();
        $actual = $validator->validateCvv($request[0]['cvv']);
        $this->assertEquals($request[1][0], $actual);
    }
}