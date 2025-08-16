<?php

namespace App\Filament\Resources\AutorResource\Pages;

use App\Filament\Resources\AutorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAutors extends ListRecords
{
    protected static string $resource = AutorResource::class;

    protected static ?string $title = 'Autores';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('Novo autor')),
        ];
    }
}
