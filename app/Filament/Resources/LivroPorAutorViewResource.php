<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LivroPorAutorViewResource\Pages;
use App\Filament\Resources\LivroPorAutorViewResource\RelationManagers;
use App\Models\Views\LivroPorAutorView;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LivroPorAutorViewResource extends Resource
{
    protected static ?string $model = LivroPorAutorView::class;
    protected static ?string $navigationLabel = 'Relatório';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $modelLabel       = 'relatório';
    protected static ?string $pluralModelLabel = 'relatórios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('autor_nome')
            ->columns([
                Tables\Columns\TextColumn::make('autor_nome')
                    ->label('Autor')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('livro_titulo')
                    ->label('Livro')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('editora')
                    ->label('Editora'),
                Tables\Columns\TextColumn::make('ano_publicacao')
                    ->label('Ano')
                    ->sortable(),
                Tables\Columns\TextColumn::make('assuntos')
                    ->label('Assuntos')
                    ->wrap(),
                Tables\Columns\TextColumn::make('valor_formatado')
                    ->label('Valor')
                    ->sortable(),
            ])
            ->groups([
                \Filament\Tables\Grouping\Group::make('autor_nome')
                    ->label('Autor'),
            ])
            ->defaultGroup('autor_nome');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLivroPorAutorViews::route('/'),
        ];
    }
}
