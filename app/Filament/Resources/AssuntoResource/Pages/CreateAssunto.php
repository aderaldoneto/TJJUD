<?php

namespace App\Filament\Resources\AssuntoResource\Pages;

use App\Filament\Resources\AssuntoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAssunto extends CreateRecord
{
    protected static string $resource = AssuntoResource::class;

    protected static ?string $title = 'Novo assunto';

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
