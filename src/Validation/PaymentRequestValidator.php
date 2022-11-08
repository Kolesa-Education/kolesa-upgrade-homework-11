<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    private const MIN_NAME_LENGTH = 2;
    private const CARD_NUMBER_LENGTH = 12;
    private const MAX_MONTH_VALUE = 12;
    private const MAX_YEAR_VALUE = 25;
    private const MIN_MONTH_VALUE = 01;
    private const MIN_YEAR_VALUE = 22;
    private const CVV_LENGTH = 3;

    public function validate(array $request): array
    {
        return array_merge(
            $this->validateNameLength($request),
            $this->validateNameString($request),
            $this->validateCardNumberLength($request),
            $this->validateExpirationFormat($request),
            $this->validateExpirationMaxValues($request),
            $this->validateExpirationMinValues($request),
            $this->validateCVV($request),
        );
    }

    private function validateNameLength(array $data): array
    {
        $nameLength = mb_strlen($data['name']);

        if ($nameLength < self::MIN_NAME_LENGTH) {
            return [
                'nameLength' => 'Минимальная длина слова - ' . self::MIN_NAME_LENGTH . ' символа'
            ];
        }

        return [];
    }

    private function validateNameString(array $data): array
    {
        $name = trim($data['name']);
        $nameParts = explode(" ", $name);

        if (count($nameParts) != 2) {
            return [
                'nameString' => 'Имя должно состоять из 2-х слов, разделенных пробелом'
            ];
        }

        return [];
    }

    private function validateCardNumberLength(array $data): array
    {
        $cardNumberLength = mb_strlen($data['cardNumber']);

        if ($cardNumberLength != self::CARD_NUMBER_LENGTH) {
            return [
                'cardNumber' => 'Номер карты должен состоять из ' . self::CARD_NUMBER_LENGTH . ' символов'
            ];
        }

        return [];
    }

    private function validateExpirationFormat(array $data): array
    {
        $expirationDate = $data['expiration'];
        $pattern = "/^[0-9][0-9]\/[0-9][0-9]$/i";

        if (!preg_match($pattern, $expirationDate)) {
            return [
                '$expirationDateFormat' => 'Неверный формат данных, необходимый формат: {число}{число}/{число}{число}',
            ];
        }

        return [];
    }

    private function validateExpirationMaxValues(array $data): array
    {
        $expirationDate = explode("/", $data['expiration']);
        $month = $expirationDate[0];
        $year = $expirationDate[1];

        if ($month > self::MAX_MONTH_VALUE || $year > self::MAX_YEAR_VALUE) {
            return [
                'expirationMaxValues' =>
                    'Максимальное значение месяца - ' . self::MAX_MONTH_VALUE .
                    ', максимальное значение года - ' . self::MAX_YEAR_VALUE,
            ];
        }

        return [];
    }

    private function validateExpirationMinValues(array $data): array
    {
        $expirationDate = explode("/", $data['expiration']);
        $month = $expirationDate[0];
        $year = $expirationDate[1];

        if ($month < self::MIN_MONTH_VALUE || $year < self::MIN_YEAR_VALUE) {
            return [
                'expirationMaxValues' =>
                    'Минимальное значение месяца - ' . self::MIN_MONTH_VALUE .
                    ', минимальное значение года - ' . self::MIN_YEAR_VALUE,
            ];
        }

        return [];
    }

    private function validateCVV(array $data): array
    {
        $cvv = $data['cvv'];

        if (!is_numeric($cvv) || strlen($cvv) !== self::CVV_LENGTH) {
            return [
                'cvv' => 'CVV код должен быть 3-х значным числом',
            ];
        }

        return [];
    }
}