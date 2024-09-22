<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvaliacaoClienteResource\Pages;
use App\Filament\Resources\AvaliacaoClienteResource\RelationManagers;
use App\Models\AvaliacaoCliente;
use App\Models\Cliente;
use App\Models\Reserva;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvaliacaoClienteResource extends Resource
{
    protected static ?string $model = AvaliacaoCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nota')
                    ->required()
                    ->numeric()
                    ->step(1)
                    ->minValue(0)
                    ->maxValue(5)
                    ->live(),
                Forms\Components\Textarea::make('comentario')
                    ->columnSpanFull(),
                Forms\Components\Select::make('reservaid')
                    ->required()
                    ->label('Cliente')
                    ->relationship('reserva.cliente', 'nome')
                    ->options(Cliente::whereHas('reservas')->pluck('nome','id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reservaid')
                    ->label('Reserva')
                    ->numeric()
                    ->state(function (AvaliacaoCliente $record): string {
                        $destino = $record->reserva->pacoteviagem->destino;
                        $nomeCliente = $record->reserva->cliente->nome;
                        return $destino . ' - ' . $nomeCliente;
                    })
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form([
                        Forms\Components\TextInput::make('nota')
                            ->readOnly()
                            ->default(function(AvaliacaoCliente $record){
                                return $record->nota;
                            }),

                        Forms\Components\Textarea::make('comentario') 
                            ->readOnly()
                            ->default(function(AvaliacaoCliente $record){
                                return $record->comentario;
                            })          
                    ]),
                Tables\Actions\DeleteAction::make(),
                ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAvaliacaoClientes::route('/'),
        ];
    }
}
