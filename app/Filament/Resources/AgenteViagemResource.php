<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgenteViagemResource\Pages;
use App\Filament\Resources\AgenteViagemResource\RelationManagers;
use App\Models\AgenteViagem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgenteViagemResource extends Resource
{
    protected static ?string $model = AgenteViagem::class;
    protected static ?string $label = 'Agentes de Viagens';

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->label('Nome')
                    ->maxLength(255),
                Forms\Components\TextInput::make('contato')
                    ->label('Contato')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('comissao')
                    ->label('Comissão')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contato')
                    ->label('Contato')
                    ->searchable(),
                Tables\Columns\TextColumn::make('comissao')
                    ->numeric()
                    ->label('Comissão')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAgenteViagems::route('/'),
        ];
    }
}
