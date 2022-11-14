<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
	const MAX_WORD_NUMBER = 2;
    const MAX_WORD_LEN = 2;
    const CARD_NUM_LEN = 16;
	
    public function validate(array $request): array
    {
		$result = [];

		$nameValidationResult = $this->validateName($request["name"]);
		if(count($nameValidationResult)!==0){
           $result = array_merge($result, $nameValidationResult); 
        }

        $cardNameValidationResult = $this->validateCardNumber($request["cardNumber"]);
        if(count($cardNameValidationResult)!==0){
           $result = array_merge($result, $cardNameValidationResult);
        }

        $expirationDateValidationResult = $this->validateExpirationDate($request["expiration"]);
        if(count($expirationDateValidationResult)!==0){
            $result = array_merge($result, $expirationDateValidationResult);
        }

        $cvvValidatonResult = $this->validateCvv($request["cvv"]);
        if(count($cvvValidatonResult)!==0){
            $result = array_merge($result, $cvvValidatonResult);
        }
        return $result;
    }
	
	public function validateName(string $name): array
    {
		$args = explode(" ", $name);
        $result = [];
		if(count($args)!==self::MAX_WORD_NUMBER){
			array_push($result, "Кол-во слов не равно " . self::MAX_WORD_NUMBER);
		}
		foreach($args as $arg) {
			if(strlen($arg)<self::MAX_WORD_LEN){
				array_push($result, "Минимальная длина слова меньше " . self::MAX_WORD_LEN);
                break;
			}
		}
		return $result;
	}
	
	public function validateCardNumber(string $number): array
    {
        $result = [];
        if(!is_numeric($number)){
            array_push($result, "В номере должны быть только цифры");
        }
        if(strlen($number)!== self::CARD_NUM_LEN){
            array_push($result, "Номер карты должен состоять из " . self::CARD_NUM_LEN . " символов");
        }
        return $result;
    }
	
	 public function validateExpirationDate(string $date): array
    {
		$args = explode("/", $date);
        $result = [];
        if(count($args)!==2){
            array_push($result, "Дата должна содержать 2 числа разделённых '/'");
            return $result;
        }
        foreach ($args as $arg) {
            if(strlen($arg)!==2 || !is_numeric($arg)){
                array_push($result, "Числа в дате должны состоять из 2 цифр");
                break;
            }
        }
        if(intval($args[0])<1 || intval($args[0])>12){
            array_push($result, "Первое число даты должно быть больше 00 и меньше 13");
        }
        if(intval($args[1])<22 || intval($args[1])>25){
            array_push($result, "Второе число даты должно быть больше 21 и меньше 26");
        }
        return $result;
    }
	
	    public function validateCvv(string $cvv): array
    {
        $result = [];
        if(!is_numeric($cvv) || strlen($cvv)!==3 ){
            array_push($result, "CVV должен содержать 3 цифры");
        }

        return $result;
    }
}