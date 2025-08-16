<?php

namespace App\Filament\Resources;

use App\Enums\Currency;
use App\Filament\Forms\Components\PriceInput;
use App\Filament\Resources\LivroResource\Pages;
use App\Filament\Resources\LivroResource\RelationManagers as Relations;
use App\Models\Livro;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class LivroResource extends Resource
{
    protected static ?string $model = Livro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(40),
                Forms\Components\TextInput::make('editora')
                    ->maxLength(40),
                Forms\Components\TextInput::make('edicao')
                    ->numeric(),
                Forms\Components\Select::make('ano_publicacao')
                    ->options(fn () => array_combine ( 
                        range((int) date('Y'), 1500), 
                        range((int) date('Y'), 1500)
                    ))
                    ->searchable()
                    ->required(),
                PriceInput::make('valor')
                    ->label(__('Valor (R$)'))
                    ->required()
                    ->formatStateUsing(function (?Livro $record) {
                        return number_format(($record?->valor ?: 0) / 100, 2, '.', '');
                    }),
                Forms\Components\Select::make('assuntos')
                    ->label('Assuntos')
                    ->multiple()
                    ->relationship('assuntos', 'descricao')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('autores')
                    ->label('Autores')
                    ->multiple()
                    ->relationship('autores', 'nome')
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('editora')
                    ->searchable(),
                Tables\Columns\TextColumn::make('edicao')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ano_publicacao')
                    ->searchable(),

                Tables\Columns\TextColumn::make('valor')
                    ->label(__('Valor (R$)'))
                    ->formatStateUsing(function (int $state) {
                        return Number::currency($state / 100, Currency::BRL->name);
                    })
                    ->default(0)
                    ->toggleable()
                    ->sortable(),

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
                    ->modalSubheading(__('Tem certeza que deseja excluir este livro?'))
                    ->modalButton(__('Sim, excluir'))
                    ->modalCancelActionLabel(__('Cancelar'))
                    ->successNotificationTitle(__('Livro excluído com sucesso!'))
                    ->failureNotificationTitle(__('Erro ao excluir livro!')),
            ]);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         Relations\AutoresRelationManager::class,
    //         Relations\AssuntosRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLivros::route('/'),
            'create' => Pages\CreateLivro::route('/create'),
            'edit' => Pages\EditLivro::route('/{record}/edit'),
        ];
    }
}
