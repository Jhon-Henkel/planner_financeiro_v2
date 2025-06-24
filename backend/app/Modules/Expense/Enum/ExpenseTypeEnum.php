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
}
