<?php

namespace Validation;

use App\Validation\Card;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{

    /**
     * @dataProvider nameProvider
     */
    public function testValidateName($name, $expected)
    {
        $card = new Card($name, "", "", "");
        $actual = $card->validateName();
        $this->assertEquals($expected, $actual);
    }

    public function nameProvider()
    {
        return
            [
                ["Хамбар Дусалиев", []],
                ["Ли Пак", []],
                ["Димас", ["name не состоит из 2 слов"]],
                ["A B", ["name и фамилия меньше 2 символов"]],
                ["Болат Болатбеков Болатович", ["name не состоит из 2 слов"]],
                ["Ли Пак1", ["name содержит недопустимые символы"]],
                ["Ли! Пак", ["name содержит недопустимые символы"]],
                ["", ["name не состоит из 2 слов"]],
            ];
    }

    /**
     * @dataProvider cardNumberProvider
     */
    public function testValidateCardNumber($cardNumber, $expected)
    {
        $card = new Card("", $cardNumber, "", "");
        $actual = $card->validateCardNumber();
        $this->assertEquals($expected, $actual);
    }

    public function cardNumberProvider()
    {
        return
            [
                [str_repeat("4", 12), []],
                [str_repeat("4", 11), ["CardNumber не состоит из 12 символов"]],
                [str_repeat("4", 13), ["CardNumber не состоит из 12 символов"]],
                [str_repeat("4", 11)."a", ["CardNumber содержит не только символы"]],
                ["4" . str_repeat("1", 11), []],
                ["1" . str_repeat("1", 11), ["CardNumber неизвестной компании"]],
                ["", ["CardNumber не состоит из 12 символов"]]
            ];
    }

    /**
     * @dataProvider expirationProvider
     */
    public function testValidateExpiration($expiration, $expected)
    {
        $card = new Card("", "", $expiration, "");
        $actual = $card->validateExpiration();
        $this->assertEquals($expected, $actual);
    }

    public function expirationProvider()
    {
        return
            [
                ["01/25", []],
                ["12/22", []],
                ["01/21", ["Невалидное значение месяца или года expiration"]],
                ["13/22", ["Невалидное значение месяца или года expiration"]],
                ["1/22", ["Не соответствует количество символов expiration"]],
                ["A1/22", ["expiration не в формате 00/00"]],
                ["01|22", ["expiration не разделен с помощью '/'"]],
                ["", ["Не соответствует количество символов expiration"]]
            ];
    }

    /**
     * @dataProvider cvvProvider
     */
    public function testValidateCvv($cvv, $expected)
    {
        $card = new Card("", "", "", $cvv);
        $actual = $card->validateCvv();
        $this->assertEquals($expected, $actual);
    }

    public function cvvProvider()
    {
        return
            [
                ["012", []],
                ["999", []],
                ["12", ["CVV должен состоять из 3 цифр"]],
                ["A23", ["CVV должен состоять из 3 цифр"]],
                ["!23", ["CVV должен состоять из 3 цифр"]],
                ["", ["CVV должен состоять из 3 цифр"]]
            ];
    }
}
