<?php

namespace App\Modules\Movement\Enum;

use InvalidArgumentException;

enum MovementTypeEnum: int
{
    case Spent = 5;
    case Received = 6;
    case Transfer = 7;

    public static function label(int $status): string
    {
        return match ($status) {
            self::Spent->value => 'Saída',
            self::Received->value => 'Entrada',
            self::Transfer->value => 'Transf.',
            default => 'Desconhecido'
        };
    }

    public static function getValues(): array
    {
        return [
            self::Spent->value,
            self::Received->value
        ];
    }

    public static function getForValidation(): string
    {
        return implode(',', self::getValues());
    }

    public static function getEnum(int $value): self
    {
        return match ($value) {
            self::Spent->value => self::Spent,
            self::Received->value => self::Received,
            self::Transfer->value => self::Transfer,
            default => throw new InvalidArgumentException("Tipo de movimentação inválido: $value")
        };
    }

    public static function rawQueryCase(string $column, bool $withAlias): string
    {
        $query = "CASE $column
                    WHEN " . self::Spent->value . " THEN '" . self::label(self::Spent->value) . "'
                    WHEN " . self::Received->value . " THEN '" . self::label(self::Received->value) . "'
                    WHEN " . self::Transfer->value . " THEN '" . self::label(self::Transfer->value) . "'
                    ELSE 'Desconhecido'
                END";
        return $withAlias ? "$query as type_label" : $query;
    }

    public static function isReceived(int $type): bool
    {
        return $type == self::Received->value;
    }

    public static function isSpent(int $type): bool
    {
        return $type == self::Spent->value;
    }
}
