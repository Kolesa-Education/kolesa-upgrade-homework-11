<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    const MAX_WORD_NUMBER = 2;
    const MAX_WORD_LEN = 2;
    const CARD_NUM_LEN = 12;
    
    public function validate(array $request): array
    {
		$result = array();
		$nameValidationResult = $this->validateName($request["name"]);
		if(strlen($nameValidationResult)!==0){
           array_push($result, $nameValidationResult); 
        }
        return $result;
        

    }

    public function validateName(string $name): string
    {
		$args = explode(" ", $name);
		if(count($args)!==self::MAX_WORD_NUMBER){
			return "Кол-во слов не равно " . self::MAX_WORD_NUMBER;
		}
		foreach($args as $arg) {
			if(strlen($arg)<self::MAX_WORD_LEN){
				return "Минимальная длина слова меньше " . self::MAX_WORD_LEN;
			}
		}
		return "";
	}	 			 
}
