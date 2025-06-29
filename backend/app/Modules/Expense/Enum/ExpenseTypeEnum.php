<?php

namespace App\Modules\Expense\Enum;

enum ExpenseTypeEnum: int
{
    case Fixed = 1;
    case OneTime = 2;
    case Installment = 3;

    public static function getForValidation(): string
    {
        return implode(',', self::getValues());
    }

    public static function getValues(): array
    {
        return [
            self::Fixed->value,
            self::OneTime->value,
            self::Installment->value
        ];
    }

    public static function label(int $code): string
    {
        return match ($code) {
            self::Fixed->value => 'Fixa',
            self::OneTime->value => 'Única',
            self::Installment->value => 'Parcelada',
            default => 'Desconhecido'
        };
    }

    public static function rawQueryCase(string $column, bool $withAlias, string $installmentColumn, string $installmentsColumn): string
    {
        $query = "CASE $column
                    WHEN " . self::Fixed->value . " THEN '" . self::label(self::Fixed->value) . "'
                    WHEN " . self::OneTime->value . " THEN '" . self::label(self::OneTime->value) . "'
                    WHEN " . self::Installment->value . " THEN CONCAT($installmentColumn, '/', $installmentsColumn)
                    ELSE 'Desconhecido'
                END";
        return $withAlias ? "$query as type_label" : $query;
    }
}
