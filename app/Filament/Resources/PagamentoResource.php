<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PagamentoResource\Pages;
use App\Filament\Resources\PagamentoResource\RelationManagers;
use App\Models\Pagamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PagamentoResource extends Resource
{
    protected static ?string $model = Pagamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('valor')
                    ->label('Valor')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('metodopagamento')
                    ->required()
                    ->label('Método de Pagamento')
                    ->options([
                        'Dinheiro' => 'Dinheiro',
                        'Cartão de Crédito' => 'Cartão de Crédito',
                        'Cartão de Débito' => 'Cartão de Débito',
                        'PIX' => 'Pix',
                        'Boleto' => 'Boleto',
                    ]),
                Forms\Components\DatePicker::make('datapagamento')
                    ->label('Data de Pagamento')
                    ->required(),
                Forms\Components\TextInput::make('reservaid')
                    ->label('Reserva ID')
                    ->readOnly()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('valor')
                    ->label('Valor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('metodopagamento')
                    ->label('Método de Pagamento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('datapagamento')
                    ->label('Data de Pagamento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reservaid')
                    ->label('Reserva ID')
                    ->numeric()
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
            'index' => Pages\ManagePagamentos::route('/'),
        ];
    }
}
