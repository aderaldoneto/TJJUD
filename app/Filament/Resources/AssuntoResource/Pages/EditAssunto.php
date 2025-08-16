<?php

namespace App\Filament\Resources\AssuntoResource\Pages;

use App\Filament\Resources\AssuntoResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class EditAssunto extends EditRecord
{
    protected static string $resource = AssuntoResource::class;

    protected static ?string $title = 'Editar assunto';

    
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
        return __('Assunto atualizado com sucesso!');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            $record->update($data);
            return $record;
        } catch (Throwable $e) {
            Notification::make()
                ->title('Erro ao atualizar assunto!')
                ->danger()
                ->send();

            throw $e;
        }
    }

}
