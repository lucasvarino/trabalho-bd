<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AluguelCarro;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AluguelCarroResource\Pages;
use App\Filament\Resources\AluguelCarroResource\RelationManagers;

class AluguelCarroResource extends Resource
{
    protected static ?string $model = AluguelCarro::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Serviços Adicionais';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->label('Nome'),
                Forms\Components\TextInput::make('descricao')
                    ->required()
                    ->maxLength(255)
                    ->label('Descrição'),
                Forms\Components\TextInput::make('preco')
                    ->label('Preço')
                    ->required()
                    ->numeric()
                    ->step('0.01'),
                Forms\Components\DatePicker::make('datainicio')
                    ->required()
                    ->label('Data Início'),
                Forms\Components\DatePicker::make('datafim')
                    ->required()
                    ->label('Data Fim'),
                Forms\Components\TextInput::make('placa')
                    ->required()
                    ->label('Placa')
                    ->regex('/^[A-Z]{3}-[0-9]{4}$/')
                    ->maxLength(50),
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
                Tables\Columns\TextColumn::make('datainicio')
                    ->label('Data Início')
                    ->formatStateUsing(function ($state) {
                        return Carbon::parse($state)
                            ->locale('pt_BR') 
                            ->translatedFormat('d F Y');
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('datafim')
                    ->label('Data Fim')
                    ->formatStateUsing(function ($state) {
                        return Carbon::parse($state)
                            ->locale('pt_BR') 
                            ->translatedFormat('d F Y');
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('placa')
                    ->label('Placa')
                    ->searchable(),
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

                            DB::statement("UPDATE {$prefix}.aluguelcarro SET datainicio = :datainicio, datafim = :datafim, placa = :placa WHERE id = :id", [
                                'datainicio' => $data['datainicio'],
                                'datafim' => $data['datafim'],
                                'placa' => $data['placa'],
                                'id' => $record->id,
                            ]);
                        });
                    }),
                Tables\Actions\DeleteAction::make()
                    ->using(function ($record) {
                        $prefix = config('database.connections.pgsql.search_path');
                        return DB::transaction(function () use ($record, $prefix) {
                            DB::statement("DELETE FROM {$prefix}.aluguelcarro WHERE id = :id", [
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
            'index' => Pages\ManageAluguelCarros::route('/'),
        ];
    }
}
