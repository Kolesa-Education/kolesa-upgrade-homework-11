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

    /**
     * @dataProvider nameProvider
     */
    public function testValidateName(string $name, $expected): void
    {
        $validator = new PaymentRequestValidator();
        $actual = $validator->validateName($name);
        $this->assertSame($expected, $actual, "Got: ".$actual ."; Want: ".$expected);
    }

    /**
     * @dataProvider cardNumberProvider
     */
    public function testValidateCardNumber(string $cardNumber, $expected): void
    {
        $validator = new PaymentRequestValidator();
        $actual = $validator->validateCardNumber($cardNumber);
        $this->assertSame($expected, $actual, "Got: ".$actual ."; Want: ".$expected);
    }

    /**
     * @dataProvider expirationProvider
     */
    public function testValidateExpiration(string $expiration, array $expected): void
    {
        $validator = new PaymentRequestValidator();
        $actual = $validator->validateExpiration($expiration);
        $this->assertSame($expected, $actual, "Got: ".implode(" ", $actual) ."; Want: ".implode(" ", $expected));
    }

    /**
     * @dataProvider cvvProvider
     */
    public function testValidateCvv(string $cvv, $expected): void
    {
        $request = [ array('name' => 'ALexey Kochevoy', 'cardNumber' => '544 322 743 123', 'expiration' => '11/22', 'cvv' => '15'),
            ["Invalid cvv length!!!"]];
        $validator = new PaymentRequestValidator();
        $actual = $validator->validateCvv($cvv);
        $this->assertSame($expected, $actual, "Got: ".$actual ."; Want: ".$expected);
    }

    public function nameProvider()
    {
        return [
            ['Alexey Kochevoy', ''],
            ['AlexeyKochevoy', 'Name on card must conteins your full name (name surname)!!!'],
            ['al a', 'Name and surname must have at least 2 symbols length!!!']
        ];
    }

    public function cardNumberProvider()
    {
        return [
            ['546 451 25 43', 'Card number\'s length must be 12 symbols!!!'],
            ['456765785099', ''],
            ['als dtg 980 145', 'Invalid card number!!!'],
            ['456 764 890 132', '']
        ];
    }

    public function expirationProvider()
    {
        return [
            ['11/25', []],
            ['1/12', ['Invalid month number in expiration, it must starts with 0 if it lower then 10!!!', 'Invalid year number in expiration!!!']],
            ['12 25', ['You must enter expiration in format : month/year!!!']],
            ['13/23', ['Invalid month number in expiration!!!']]
        ];
    }

    public function cvvProvider()
    {
        return [
            ['056', ''],
            ['15', 'Invalid cvv length!!!'],
            ['560', 'Invalid cvv!!!'],
            ['105', 'Invalid cvv!!!'],
            ['ac1', 'cvv must be three digit number!!!'],
            ['456', '']
        ];
    }
}