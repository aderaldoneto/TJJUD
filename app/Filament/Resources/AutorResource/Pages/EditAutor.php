<?php

namespace App\Filament\Resources\AutorResource\Pages;

use App\Filament\Resources\AutorResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class EditAutor extends EditRecord
{
    protected static string $resource = AutorResource::class;

    protected static ?string $title = 'Editar autor';

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
        return __('Autor atualizado com sucesso!');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            $record->update($data);
            return $record;
        } catch (Throwable $e) {
            Notification::make()
                ->title('Erro ao atualizar autor!')
                ->danger()
                ->send();

            throw $e;
        }
    }
}
