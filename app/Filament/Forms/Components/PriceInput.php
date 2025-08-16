<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;

class PriceInput extends TextInput
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->prefix('R$')
            ->live(debounce: 300)
            ->minValue(1)
            ->maxValue(999_99)
            ->numeric()
            ->decimals(2);
    }

    public function decimals(int $precision): static
    {
        return $this
            ->step(pow(10, -$precision))
            ->formatStateUsing(function (null|int|float $state) use ($precision) {
                return number_format(($state ?: 0) / 100, $precision, '.', '');
            })
            ->dehydrateStateUsing(function (mixed $state) use ($precision) {
                if (! is_numeric($state)) {
                    return null;
                }

                if ($precision <= 2) {
                    return (int) ($state * 100);
                }

                return (float) ($state * 100);
            });
    }
}
