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
                ["A B", ["Имя и фамилия меньше 2 символов"]],
                ["Болат Болатбеков Болатович", ["name не состоит из 2 слов"]]
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
                [str_repeat("1", 12), []],
                [str_repeat("1", 11), ["CardNumber не состоит из 12 символов"]],
                [str_repeat("1", 13), ["CardNumber не состоит из 12 символов"]],
                [str_repeat("1", 11)."a", ["CardNumber содержит не только символы"]],
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
                ["01|22", ["expiration не разделен с помощью '/'"]]
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
                ["A23", ["CVV должен состоять из 3 цифр"]]
            ];
    }
}
