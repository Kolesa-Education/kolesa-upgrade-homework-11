<?php

declare(strict_types=1);

use App\Validation\CheckValidation;
use PHPUnit\Framework\TestCase;

class CheckValidationTest extends TestCase {

    public function testNameValidator($name, $expected)
    {
        $card = new CheckValidation($name, "", "", "");
        $actual = $card->nameValidator();
        $this->assertEquals($expected, $actual);
    }
    public function nameProvider(){
        return
            [
                ["Хамбар Дусалиев", []],
                ["Ли12 Пак", ["Only use letter"]],
                ["Манара", ["Имя должно быть не больше 2 символов"]],
                ["A B", ["Имя должно быть не больше 2 символов"]],
                ["Болат Болатбеков Болатович", ["Имя должно быть не больше 2 символов"]]
            ];
    }
    public function testCardNumberValidator($cardNumber, $expected)
    {
        $card = new CheckValidation("", $cardNumber, "", "");
        $actual = $card->cardNumberValidator();
        $this->assertEquals($expected, $actual);
    }

    public function cardNumberProvider()
    {
        return
            [
                [str_repeat("1", 12), []],
                [str_repeat("1", 11), ["Здесь должно быть только 12 число"]],
                [str_repeat("1", 12)."manara", ["Only use digit"]],
            ];
    }

    /**
     * @dataProvider expirationProvider
     */
    public function testExpValidator($expiration, $expected)
    {
        $card = new CheckValidation("", "", $expiration, "");
        $actual = $card->expValidator();
        $this->assertEquals($expected, $actual);
    }

    public function expirationProvider()
    {
        return
            [
                ["12/26", []],
                ["33/26", ["Incorrect input"]],
                ["1/26", ["Too many characters"]],
                ["SS/26", ["Incorrect"]],
                ["12%26", ["Use correct symbol"]],
            ];
    }

    /**
     * @dataProvider cvvProvider
     */
    public function testcvvValidator($cvv, $expected)
    {
        $card = new CheckValidation("", "", "", $cvv);
        $actual = $card->cvvValidator();
        $this->assertEquals($expected, $actual);
    }

    public function cvvProvider()
    {
        return
            [
                ["123", []],
                ["Afb", ["Only use digit"]],
                ["1234", ["Too many args"]]
            ];
    }

}