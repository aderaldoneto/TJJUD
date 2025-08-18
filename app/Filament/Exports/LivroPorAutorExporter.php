<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Enums\Currency;
use App\Models\Publication;
use App\Models\Views\LivroPorAutorView;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class LivroPorAutorExporter extends Exporter
{
    protected static ?string $model = LivroPorAutorView::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('autor_nome')
                ->label(__('Nome')),

            ExportColumn::make('livro_titulo')
                ->label(__('Titulo')),

            ExportColumn::make('editora')
                ->label(__('Editora')),

            ExportColumn::make('ano_publicacao')
                ->label(__('Ano publicacao'))
                ->formatStateUsing(fn ($state) => (string) $state),

            ExportColumn::make('valor')
                ->label(__('Valor'))
                ->formatStateUsing(function (int $state) {
                    return Number::currency($state / 100, Currency::BRL->name);
                }),
            ExportColumn::make('assuntos')
                ->label(__('Assuntos')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Processo finalizado!';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' falha na exportação.';
        }

        return $body;
    }
}
