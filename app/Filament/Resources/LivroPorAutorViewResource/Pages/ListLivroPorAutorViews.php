<?php

namespace App\Filament\Resources\LivroPorAutorViewResource\Pages;

use App\Filament\Resources\LivroPorAutorViewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLivroPorAutorViews extends ListRecords
{
    protected static string $resource = LivroPorAutorViewResource::class;

    protected static ?string $title = 'Relatório';
    
}
