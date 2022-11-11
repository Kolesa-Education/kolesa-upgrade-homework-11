<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    public function nameValidationProvider()
    {
        return [
            ["aa aa", []],
            ["aa a", ["Минимальная длина слова меньше " . PaymentRequestValidator::MAX_WORD_LEN]],
            ["", [
                "Кол-во слов не равно " . PaymentRequestValidator::MAX_WORD_NUMBER,
                "Минимальная длина слова меньше " . PaymentRequestValidator::MAX_WORD_LEN
            ]]
        ];
    }

    /**
     * @dataProvider nameValidationProvider
     */
    public function testNameValidation(string $input, array $expected): void
    {
        $validator = new PaymentRequestValidator();
        $this->assertEquals($expected, $validator->validateName($input));
    }
}