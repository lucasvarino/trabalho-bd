<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PacoteViagemResource\Pages;
use App\Filament\Resources\PacoteViagemResource\RelationManagers;
use App\Models\DestinoTuristico;
use App\Models\Hotel;
use App\Models\PacoteViagem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PacoteViagemResource extends Resource
{
    protected static ?string $model = PacoteViagem::class;
    protected static ?string $label = 'Pacotes de Viagem';

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('destino')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('datadepartida')
                    ->label('Data de Partida')
                    ->required(),
                Forms\Components\DatePicker::make('dataderetorno')
                    ->label('Data de Retorno')
                    ->required(),
                Forms\Components\TextInput::make('preco')
                    ->label('Preço')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('tipopacoteid')
                    ->label('Tipo do Pacote')
                    ->required()
                    ->relationship('tipoPacote', 'nome')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('duracao')
                            ->label('Duração (em dias)')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('tematica')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\TextInput::make('capacidademaxima')
                    ->label('Capacidade máxima')
                    ->required()
                    ->numeric()
                    ->default(5),
                Forms\Components\Select::make('hoteis')
                    ->label('Hoteis')
                    ->relationship('hoteis', 'hotelid')
                    ->options(Hotel::all()->pluck('nome', 'id'))
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('endereco')
                            ->label('Endereço')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->multiple(),
                Forms\Components\Select::make('destinosTuristicos')
                    ->label('Destinos Turísticos')
                    ->relationship('destinosTuristicos', 'destinoturisticoid')
                    ->options(DestinoTuristico::all()->pluck('nome', 'id'))
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('descricao')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->searchable()
                    ->multiple()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('destino')
                    ->searchable(),
                Tables\Columns\TextColumn::make('datadepartida')
                    ->label('Data de Partida')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dataderetorno')
                    ->label('Data de Retorno')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('preco')
                    ->label('Preço')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipoPacote.nome')
                    ->label('Tipo do Pacote')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacidademaxima')
                    ->label('Capacidade Máxima')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classificacao')
                    ->label('Classificação')
                    ->state(function (PacoteViagem $pacote) {
                        return number_format($pacote->reservas->avg('avaliacaoCliente.nota'), 2);
                    })
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
            'index' => Pages\ListPacoteViagems::route('/'),
            'create' => Pages\CreatePacoteViagem::route('/create'),
            'edit' => Pages\EditPacoteViagem::route('/{record}/edit'),
        ];
    }
}
