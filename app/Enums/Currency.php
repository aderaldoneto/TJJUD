<?php

declare(strict_types=1);

namespace App\Enums;

enum Currency
{
    case BRL;

    public function symbol(): string
    {
        return match ($this) {
            self::BRL => 'R$',
        };
    }
}


