<?php

namespace App\Observers;

use App\Models\Assunto;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Validation\ValidationException;

class AssuntoObserver
{

    public function saving(Assunto $assunto): void
    {
        $descricao = trim((string) $assunto->descricao);
        $assunto->descricao = $descricao;

        $seExiste = Assunto::query()
            ->whereRaw('LOWER(descricao) = ?', [mb_strtolower($descricao, 'UTF-8')])
            ->when($assunto->exists, fn ($q) => $q->where('id', '!=', $assunto->id))
            ->exists();

        if ($seExiste) {
            Notification::make()
                ->title('Já existe um assunto com essa descrição!')
                ->danger()
                ->send();

            throw new Halt;
        }
    }
}
