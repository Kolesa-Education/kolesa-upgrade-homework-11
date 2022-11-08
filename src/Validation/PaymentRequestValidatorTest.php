<?php

declare(strict_types=1);

namespace App\Validation;

use PHPUnit\Framework\TestCase;
use Exception;

require_once 'vendor/autoload.php';

class PaymentRequestValidatorTest extends TestCase
{
    public function validate(array $request): array
    {
        $errors = [];
        $number = $request["cardNumber"];
        $cvv = $request["cvv"];
        $expiration = $request["expiration"];
        $n_arr = explode(" ", $request["name"]);
        $name_count = count($n_arr);
        if (!$this->testIstwowords($name_count)) {
            array_push($errors, "Имя состоит не из двух слов\n");
        };
        if (!$this->testIsmoretwoletters($n_arr)) {
            array_push($errors, "Имя или фамилия состоят меньше чем из двух букв\n");
        }
        if (!$this->isvalidnumber($number)) {
            array_push($errors, "Номер карты состоит не из 12 цифр или содержит не цифры\n");
        }
        if (!$this->isvalidcvv($cvv)) {
            array_push($errors, "CVV состоит не из 3 цифр или содержит не цифры\n");
        }
        if (!$this->isvalidexpiredate($expiration)) {
            array_push($errors, "Дата окончания не соответствует необходимому периоду\n");
        }
        if (!$this->testIscapwords($request["name"])) {
            //Добавил новую проверку, к сожалению работает только с латинскими именами
            array_push($errors, "Имя и/или фамилия написаны не с заглавной буквы\n");
        }
        return $errors;
    }

    public function isvalidexpiredate(string $expiredate): bool
    {
        try {
            if (str_contains($expiredate, '/')) {
                $n_arr = explode("/", $expiredate);
                if (count($n_arr) == 2 && strlen($n_arr[0]) == 2 && strlen($n_arr[1]) == 2) {
                    $this->assertGreaterThanOrEqual(1, (int)$n_arr[0]);
                    $this->assertGreaterThanOrEqual(22, intval($n_arr[1]));
                    $this->assertGreaterThanOrEqual(intval($n_arr[0]), 12);
                    $this->assertGreaterThanOrEqual(intval($n_arr[1]), 25);
                    return true;

                }
                return false;
            }
            return false;

        } catch (Exception $e) {
            return false;

        }
    }

    public function isvalidnumber(string $number): bool
    {
        try {
            $number = intval($number);
            $this->assertEquals(strlen((string)$number), 12);
            return true;
        } catch (Exception $e) {
            return false;

        }


    }

    public function isvalidcvv(string $number): bool
    {
        try {
            $number = intval($number);
            $this->assertEquals(strlen((string)$number), 3);
            return true;
        } catch (Exception $e) {
            return false;

        }


    }

    public function testIstwowords(int $name_count): bool
    {
        try {
            $this->assertEquals($name_count, 2);
            return true;
        } catch (Exception $e) {
            return false;

        }
    }

    public function testIsmoretwoletters(array $name_arr): bool
    {
        try {
            $name_count = count($name_arr);
            $i = 0;
            do {
                $this->assertGreaterThan(2, strlen($name_arr[$i]));
                $i++;
            } while ($i < $name_count);
            return true;


        } catch (Exception $e) {
            return false;
        }
    }

    public function testIscapwords(string $name): bool
    {
        try {
            $this->assertEquals($name, ucwords($name));
            return true;
        } catch (Exception $e) {
            return false;

        }


    }
}