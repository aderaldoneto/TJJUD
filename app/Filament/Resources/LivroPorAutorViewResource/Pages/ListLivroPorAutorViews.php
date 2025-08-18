<?php

namespace App\Filament\Resources\LivroPorAutorViewResource\Pages;

use App\Filament\Exports\LivroPorAutorExporter;
use App\Filament\Resources\LivroPorAutorViewResource;
use App\Models\Views\LivroPorAutorView;
use Dompdf\Dompdf;
use Dompdf\Options;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListLivroPorAutorViews extends ListRecords
{
    protected static string $resource = LivroPorAutorViewResource::class;

    protected static ?string $title = 'Relatório';

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label(__('Baixar'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->columnMapping(false)
                ->modalHeading(__('Exportar relatório!'))
                ->exporter(LivroPorAutorExporter::class)
                ->fileName('relatorio-livros-'.now()->format('Y-m-d_H-i')),
        ];
    }
    
}
