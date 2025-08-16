<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AutorResource\Pages;
use App\Filament\Resources\AutorResource\RelationManagers;
use App\Models\Autor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AutorResource extends Resource
{
    protected static ?string $model = Autor::class;

    protected static ?string $navigationLabel = 'Autores';

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square'; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(40),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Editar')),

                Tables\Actions\DeleteAction::make()
                ->label(__('Excluir'))
                ->requiresConfirmation()
                ->modalHeading(fn ($record) => 'Excluir: "'.$record->nome.'"?')
                ->modalSubheading(__('Tem certeza que deseja excluir este autor?'))
                ->modalButton(__('Sim, excluir'))
                ->modalCancelActionLabel(__('Cancelar'))
                ->successNotificationTitle(__('Autor excluído com sucesso!'))
                ->failureNotificationTitle(__('Erro ao excluir autor!')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAutors::route('/'),
            'create' => Pages\CreateAutor::route('/create'),
            'edit' => Pages\EditAutor::route('/{record}/edit'),
        ];
    }
}
