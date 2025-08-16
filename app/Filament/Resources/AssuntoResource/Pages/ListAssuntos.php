<?php

namespace App\Filament\Resources\AssuntoResource\Pages;

use App\Filament\Resources\AssuntoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssuntos extends ListRecords
{
    protected static string $resource = AssuntoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('Novo assunto')),
        ];
    }
}
