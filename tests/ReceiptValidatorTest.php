<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class ReceiptValidatorTest extends TestCase
{
    public function testNoErrors(): void
    {
        $expected = [];

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "123456789101";
        $testdata['expiration'] = "05/25";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testErrorName1(): void
    {
        $expected = [];

        $expected[] = "name не состоит их 2-х слов";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman";
        $testdata['cardNumber'] = "123456789101";
        $testdata['expiration'] = "05/25";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testErrorName2(): void
    {
        $expected = [];

        $expected[] = "Минимальная длина имен/фамилии 2 символа";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman F";
        $testdata['cardNumber'] = "123456789101";
        $testdata['expiration'] = "05/25";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testErrorCardNumber1(): void
    {
        $expected = [];

        $expected[] = "Длина номера карты должно быть 12";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "12345678901";
        $testdata['expiration'] = "05/25";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testErrorCardNumber2(): void
    {
        $expected = [];

        $expected[] = "Номер карты должен состоять из цифр";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "123456789a01";
        $testdata['expiration'] = "05/25";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testErrorCardNumber3(): void
    {
        $expected = [];

        $expected[] = "Длина номера карты должно быть 12";
        $expected[] = "Номер карты должен состоять из цифр";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "";
        $testdata['expiration'] = "05/25";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testErrorExpiration1(): void
    {
        $expected = [];

        $expected[] = "В дате истечении не две строки разделенных /";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "123456789101";
        $testdata['expiration'] = "05/25/66";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testErrorExpiration2(): void
    {
        $expected = [];

        $expected[] = "В месяце истечения больше двух символов";
        $expected[] = "В годе истечения больше двух символов";
        $expected[] = "Дата должна состоять из цифр";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "123456789101";
        $testdata['expiration'] = "055/25a";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testErrorExpiration3(): void
    {
        $expected = [];

        $expected[] = "Месяц не в range [0,12]";
        $expected[] = "Год не в range [22,25]";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "123456789101";
        $testdata['expiration'] = "15/26";
        $testdata['cvv'] = "123";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testCVV1(): void
    {
        $expected = [];

        $expected[] = "cvv не трехзначное число";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "123456789101";
        $testdata['expiration'] = "12/25";
        $testdata['cvv'] = "12345";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testCVV2(): void
    {
        $expected = [];

        $expected[] = "CVV должен состоять из цифр";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman Fazyl";
        $testdata['cardNumber'] = "123456789101";
        $testdata['expiration'] = "12/25";
        $testdata['cvv'] = "1a5";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }

    public function testAllErrors(): void
    {
        $expected = [];

        $expected[] = "Минимальная длина имен/фамилии 2 символа";
        $expected[] = "Длина номера карты должно быть 12";
        $expected[] = "Номер карты должен состоять из цифр";        
        $expected[] = "Месяц не в range [0,12]";
        $expected[] = "Год не в range [22,25]";
        $expected[] = "CVV должен состоять из цифр";

        $validator = new PaymentRequestValidator();

        $testdata = [];

        $testdata['name'] = "Yelaman F";
        $testdata['cardNumber'] = "12345678ad0a1";
        $testdata['expiration'] = "13/30";
        $testdata['cvv'] = "1a5";
        
        $actual = $validator->validate($testdata);

        $this->assertEquals($expected, $actual);
    }
}