<?php

namespace App\Filament\Resources\LivroResource\Pages;

use App\Filament\Resources\LivroResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class EditLivro extends EditRecord
{
    protected static string $resource = LivroResource::class;

    protected static ?string $title = 'Editar livro';

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label(__('Salvar')),

            $this->getCancelFormAction()
                ->label(__('Cancelar')),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('Livro atualizado com sucesso!');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            $record->update($data);
            return $record;
        } catch (Throwable $e) {
            Notification::make()
                ->title('Erro ao atualizar livro!')
                ->danger()
                ->send();

            throw $e;
        }
    }
}
