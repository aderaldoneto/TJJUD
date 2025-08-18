<?php

namespace App\Observers;

use App\Models\Livro;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

class LivroObserver
{
    public function saving(Livro $assunto): void
    {
        if($assunto->ano_publicacao > date('Y')){
            Notification::make()
                ->title('O ano de publicação não pode ser maior que o ano atual!')
                ->danger()
                ->send();

            throw new Halt();
        }

        if($assunto->edicao <= 0){
            Notification::make()
                ->title('Digite uma edição válida!')
                ->danger()
                ->send();
                
            throw new Halt();
        }
    }
}
