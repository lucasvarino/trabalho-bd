<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VooResource\Pages;
use App\Filament\Resources\VooResource\RelationManagers;
use App\Models\CompanhiaAerea;
use App\Models\Voo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class VooResource extends Resource
{
    protected static ?string $model = Voo::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationGroup = 'Serviços Adicionais';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descricao')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('preco')
                    ->label('Preço')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('horariopartida')
                    ->label('Horário de Partida')
                    ->required(),
                Forms\Components\TextInput::make('horariochegada')
                    ->label('Horário de Chegada')
                    ->required(),
                Forms\Components\Select::make('companhiaaereaid')
                    ->label('Companhia Aérea')
                    ->relationship('companhiaAerea', 'nome')
                    ->options(CompanhiaAerea::all()->pluck('nome', 'id'))
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nome')
                            ->label('Nome')
                            ->required(),
                        Forms\Components\TextInput::make('sede')
                            ->label('Sede')
                            ->required(),
                    ])
                    ->required()
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
                Tables\Columns\TextColumn::make('servicoAdicional.nome')
                    ->searchable()
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('servicoAdicional.preco')
                    ->label('Preço'),
                Tables\Columns\TextColumn::make('horariopartida')
                    ->label('Horário de Partida'),
                Tables\Columns\TextColumn::make('horariochegada')
                    ->label('Horário de Chegada'),
                Tables\Columns\TextColumn::make('companhiaAerea.nome')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function ($data) {
                        $prefix = config('database.connections.pgsql.search_path');
                        $servicoAdicional = DB::select("SELECT * FROM {$prefix}.servicoadicional WHERE id = :id", [
                            'id' => $data['id'],
                        ]);
                        $data['nome'] = $servicoAdicional[0]->nome;
                        $data['descricao'] = $servicoAdicional[0]->descricao;
                        $data['preco'] = $servicoAdicional[0]->preco;

                        return $data;
                    })
                    ->using(function ($record, $data) {
                        $prefix = config('database.connections.pgsql.search_path');
                        return DB::transaction(function () use ($record, $prefix, $data) {
                            DB::statement("UPDATE {$prefix}.servicoadicional SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id", [
                                'nome' => $data['nome'],
                                'descricao' => $data['descricao'],
                                'preco' => $data['preco'],
                                'id' => $record->id,
                            ]);

                            DB::statement("UPDATE {$prefix}.voo SET horariopartida = :horariopartida, horariochegada = :horariochegada, companhiaaereaid = :companhiaaereaid WHERE id = :id", [
                                'horariopartida' => $data['horariopartida'],
                                'horariochegada' => $data['horariochegada'],
                                'companhiaaereaid' => $data['companhiaaereaid'],
                                'id' => $record->id,
                            ]);
                        });
                    }),
                Tables\Actions\DeleteAction::make()
                ->using(function ($record) {
                        $prefix = config('database.connections.pgsql.search_path');
                        return DB::transaction(function () use ($record, $prefix) {
                            DB::statement("DELETE FROM {$prefix}.voo WHERE id = :id", [
                                'id' => $record->id,
                            ]);

                            DB::statement("DELETE FROM {$prefix}.servicoadicional WHERE id = :id", [
                                'id' => $record->id,
                            ]);
                        });
                }),
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
            'index' => Pages\ManageVoos::route('/'),
        ];
    }
}
