<?php

namespace App\Filament\Resources\AutorResource\Pages;

use App\Filament\Resources\AutorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAutor extends CreateRecord
{
    protected static string $resource = AutorResource::class;

    protected static ?string $title = 'Novo autor';

    protected static bool $canCreateAnother = false;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label(__('Salvar')),

            $this->getCancelFormAction()
                ->label(__('Cancelar')),
        ];
    }

}
