<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservaResource\Pages;
use App\Filament\Resources\ReservaResource\RelationManagers;
use App\Models\AgenteViagem;
use App\Models\AvaliacaoCliente;
use App\Models\Cliente;
use App\Models\PacoteViagem;
use App\Models\Reserva;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class ReservaResource extends Resource
{
    protected static ?string $model = Reserva::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('clienteid')
                    ->required()
                    ->label('Cliente')
                    ->relationship('cliente', 'nome')
                    ->options(Cliente::all()->pluck('nome', 'id'))
                    ->searchable()
                    ->createOptionForm([
                            Forms\Components\TextInput::make('nome')
                                ->label('Nome')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('contato')
                                ->required()
                                ->label('Contato')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('identidade')
                                ->required()
                                ->label('Identidade')
                                ->maxLength(11),
                ]),
                Forms\Components\Select::make('pacoteviagemid')
                    ->required()
                    ->label('Pacote de Viagem')
                    ->relationship('pacoteviagem', 'destino')
                    ->options(PacoteViagem::all()->pluck('destino', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('agenteviagemid')
                    ->required()
                    ->label('Agente de Viagem')
                    ->relationship('agenteviagem', 'nome')
                    ->options(AgenteViagem::all()->pluck('nome', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('datareserva')
                    ->label('Data da reserva')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'Pendente' => 'Pendente',
                        'Confirmada' => 'Confirmada',
                        'Cancelada' => 'Cancelada'
                    ])
                    ->default('Pendente')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->label("Cliente")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pacoteviagem.destino')
                    ->label('Pacote viagem (Destino)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('agenteviagem.nome')
                    ->label('Agente de viagem')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('datareserva')
                    ->label('Data da reserva')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendente' => 'warning',
                        'Confirmada' => 'success',
                        'Cancelada' => 'danger',
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Avaliar')
                    ->model(AvaliacaoCliente::class)
                    ->color('success')
                    ->visible(function(Reserva $record):bool{
                        return $record->status === "Confirmada";
                    })
                    ->form([
                        Forms\Components\TextInput::make('nota')
                            ->required()
                            ->numeric()
                            ->step(1)
                            ->minValue(0)
                            ->maxValue(5)
                            ->live(),
                        Forms\Components\Textarea::make('comentario')             
                    ])
                    ->action(function (array $data, Reserva $record): void {
                        AvaliacaoCliente::create([
                            "nota" => $data["nota"],
                            "comentario" => $data["comentario"],
                            "reservaid" => $record->id
                        ]);

                        Notification::make()
                        ->title('Avaliação realizada com sucesso!')
                        ->success()
                        ->send();
                    }),
                ]),
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
            'index' => Pages\ManageReservas::route('/'),
        ];
    }
}
