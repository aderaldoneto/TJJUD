<?php

namespace App\Filament\Resources\LivroResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AutoresRelationManager extends RelationManager
{
    protected static string $relationship = 'autores';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nome')->label('Autor')->searchable(),
        ])
        ->headerActions([
            Tables\Actions\AttachAction::make()
                ->label('Adicionar autor')
                ->modalHeading('Selecionar autor')
                ->modalButton('Vincular')
                ->recordTitleAttribute('nome')
                ->preloadRecordSelect()
                ->recordSelectSearchColumns(['nome'])
                ->recordSelectOptionsQuery(fn ($q) => $q->orderBy('nome')),
            // ❌ não use CreateAction se você quer só selecionar existentes
        ])
        ->actions([
            Tables\Actions\DetachAction::make()->label('Remover'),
        ]);
}
}
