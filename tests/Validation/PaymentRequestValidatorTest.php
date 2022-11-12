<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    /** 
     * @dataProvider arrayProvider 
    */
    public function testValidate($request, $expected):void{
        $validator = new PaymentRequestValidator();
        
        $actual = $validator->validate($request);

        $this->assertEquals($expected, $actual);

        // $this->assertEmpty($actual,implode(",\n",$actual));
    }

    public function arrayProvider()
    {
        return[
            "everything is valid" =>[
                ['name'=>'John Wick', 'cardNumber'=>'123456789123', 'expiration'=>'05/25', 'cvv'=>'003'],
                []
            ],
            "all empty fields" =>[
                ['name'=>'', 'cardNumber'=>'', 'expiration'=>'', 'cvv'=>''],
                ['name не записан', 'cardNumber не записан', 'expiration не записан', 'cvv не записан']
            ],
            "invalid name and expiration date" =>[
                ['name'=>'JohnWick', 'cardNumber'=>'321987654458', 'expiration'=>'1/12', 'cvv'=>'203'],
                ['name не состоит их 2-х слов', 'expiration записан в недопустимом формате']
            ],
            "invalid cvv, cardNumber" =>[
                ['name'=>'Test User', 'cardNumber'=>'123456888', 'expiration'=>'02/24', 'cvv'=>'a12'],
                ['cardNumber не 12-ти значное число', 'cvv не состоит только из цифр']
            ],
            "all invalid fields" =>[
                ['name'=>'Makpal Hay Ades', 'cardNumber'=>'123456789aa', 'expiration'=>'01/26', 'cvv'=>'5556'],
                ['name не состоит их 2-х слов', 'cardNumber не 12-ти значное число',
                'cardNumber не состоит только из цифр', 'expiration записан в недопустимом формате','cvv не 3-x значное число']
            ], 
        ];
    }
}