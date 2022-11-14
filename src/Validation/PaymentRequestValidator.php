<?php

declare (strict_types = 1);

namespace App\Validation;

class PaymentRequestValidator {
    private $data;
    private $errors = [];

    public function validate(array $request): array {
        $this->validateName($request);
        $this->validateCardNumber($request);
        $this->validateExpiration($request);
        $this->validateCvv($request);

        return $this->errors;
    }

    private function validateName(array $data): array {
        $val = trim($data['name']);
        $subName = explode(" ", $val);

        if (count($subName) != 2) {
            $this->addError('name', 'name must consist of two words');
        }

        if (count($subName) > 1) {
            $firstNameLen = strlen($subName[0]);
            $lastNameLen = strlen($subName[1]);

            if ($firstNameLen < 2 || $lastNameLen < 2) {
                $this->addError('name', 'firstname and lastname must be at least 2 chars');
            }

        }

        return $this->errors;
    }

    private function validateCardNumber(array $data): array {
        $val = trim($data['cardNumber']);

        if (empty($val)) {
            $this->addError('cardNumber', 'cardNumber cannot be empty');
        } else {
            if (!is_numeric($val) || strlen($val) != 12) {
                $this->addError('cardNumber', 'cardNumber must be 12 chars & numeric');
            }
        }
        return $this->errors;

    }

    private function validateExpiration(array $data): array {
        $val = trim($data['expiration']);

        if (empty($val)) {
            $this->addError('expiration', 'expiration cannot be empty');
        } else {
            if (!preg_match('/^[0-9][0-9]\/[0-9][0-9]$/', $val)) {
                $this->addError('expiration', 'expiration must consist of {number}{number}/{number}{number}');
            }
        }

        $subDate = explode("/", $val);

        if (count($subDate) > 1) {
            $monthLen = strlen($subDate[0]);
            $yearLen = strlen($subDate[0]);

            if (count($subDate) != 2 || $monthLen != 2 || $yearLen != 2) {
                $this->addError('expiration', 'expiration month and year must be 2 chars each');
            }

            $month = str_pad($subDate[0], 2, '0', STR_PAD_LEFT);
            $year = is_numeric($subDate[1]);

            if ($month > 12 || $year < 22 || $year > 25) {
                $this->addError('expiration', 'expiration must consist of month from 01 to 12 and year from 22 to 25');
            }
        }

        return $this->errors;

    }

    private function validateCvv(array $data): array {
        $val = trim($data['cvv']);

        if (empty($val)) {
            $this->addError('cvv', 'cvv cannot be empty');
        } else {
            if (!is_numeric($val) || strlen($val) != 3) {
                $this->addError('cvv', 'cvv must be 3 chars & numeric');
            }
        }
        return $this->errors;

    }

    private function addError($key, $val) {
        $this->errors[$key] = $val;
    }
}