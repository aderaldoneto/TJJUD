<?php

namespace App\Filament\Resources;

use App\Enums\Currency;
use App\Filament\Forms\Components\PriceInput;
use App\Filament\Resources\LivroResource\Pages;
use App\Filament\Resources\LivroResource\RelationManagers as Relations;
use App\Models\Autor;
use App\Models\Livro;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class LivroResource extends Resource
{
    protected static ?string $model = Livro::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

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
                    ->numeric()
                    ->step(1)
                    ->minValue(1)
                    ->rules(['integer', 'min:1']),
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('editora')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('edicao')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ano_publicacao')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('valor')
                    ->label(__('R$'))
                    ->formatStateUsing(function (int $state) {
                        return Number::currency($state / 100, Currency::BRL->name);
                    })
                    ->default(0)
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('autores')
                    ->label(__('Autor'))
                    ->relationship('autores', 'nome')
                    ->preload()
                    ->options(function () {

                        return Autor::query()
                            ->pluck('nome', 'id')
                            ->toArray();
                    })
                    ->multiple(),
                Tables\Filters\SelectFilter::make('assuntos')
                    ->label(__('Assunto'))
                    ->relationship('assuntos', 'descricao')
                    ->preload()
                    ->options(function () {

                        return Autor::query()
                            ->pluck('descricao', 'id')
                            ->toArray();
                    })
                    ->multiple(),
                Filter::make('valor')
                    ->label(__('Preço'))
                    ->form([
                        PriceInput::make('max')
                            ->label(__('Valor máximo (R$)')),
                    ])
                    ->indicateUsing(function (array $data) {
                        if (empty($data['max']) || ! (int) $data['max']) {
                            return null;
                        }

                        return __('Valor máximo').': '.Number::currency($data['max'], Currency::BRL->name);
                    })
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['max']) || ! (int) $data['max']) {
                            return;
                        }

                        $max = $data['max'] * 100;

                        $query->where('valor', '<=', $max);
                    }),
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
