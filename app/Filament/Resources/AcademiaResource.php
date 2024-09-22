<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademiaResource\Pages;
use App\Filament\Resources\AcademiaResource\RelationManagers;
use App\Models\Academia;
use App\Models\ServicoAdicional;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class AcademiaResource extends Resource
{
    protected static ?string $model = Academia::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Forms\Components\TextInput::make('endereco')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('horariofuncionamento')
                    ->label('Horário de Funcionamento')
                    ->required()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('endereco')
                    ->searchable(),
                Tables\Columns\TextColumn::make('horariofuncionamento')
                    ->label('Horário de Funcionamento')
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

                        DB::statement("UPDATE {$prefix}.academia SET endereco = :endereco, horariofuncionamento = :horariofuncionamento WHERE id = :id", [
                            'endereco' => $data['endereco'],
                            'horariofuncionamento' => $data['horariofuncionamento'],
                            'id' => $record->id,
                        ]);
                    });
                }),
                Tables\Actions\DeleteAction::make()
                ->using(function ($record) {
                    $prefix = config('database.connections.pgsql.search_path');
                    return DB::transaction(function () use ($record, $prefix) {
                        DB::statement("DELETE FROM {$prefix}.academia WHERE id = :id", [
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
            'index' => Pages\ManageAcademias::route('/'),
        ];
    }
}
