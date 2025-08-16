<?php

namespace App\Filament\Resources\LivroResource\Pages;

use App\Filament\Resources\LivroResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLivro extends CreateRecord
{
    protected static string $resource = LivroResource::class;

    protected static ?string $title = 'Novo livro';

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
