<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssuntoResource\Pages;
use App\Filament\Resources\AssuntoResource\RelationManagers;
use App\Models\Assunto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssuntoResource extends Resource
{
    protected static ?string $model = Assunto::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag'; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')
                    ->label(__('Descrição'))
                    ->required()
                    ->maxLength(20)
                    ->placeholder(__('Digite a descrição/gênero de livro')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Editar')),

                Tables\Actions\DeleteAction::make()
                    ->label(__('Excluir'))
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => 'Excluir: "'.$record->descricao.'"?')
                    ->modalSubheading(__('Tem certeza que deseja excluir este assunto?'))
                    ->modalButton(__('Sim, excluir'))
                    ->modalCancelActionLabel(__('Cancelar'))
                    ->successNotificationTitle(__('Assunto excluído com sucesso!'))
                    ->failureNotificationTitle(__('Erro ao excluir assunto!')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssuntos::route('/'),
            'create' => Pages\CreateAssunto::route('/create'),
            'edit' => Pages\EditAssunto::route('/{record}/edit'),
        ];
    }
}
