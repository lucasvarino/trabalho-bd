<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PasseioResource\Pages;
use App\Filament\Resources\PasseioResource\RelationManagers;
use App\Models\Passeio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class PasseioResource extends Resource
{
    protected static ?string $model = Passeio::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
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
                    ->maxLength(255)
                    ->label('Descrição'),
                Forms\Components\TextInput::make('preco')
                    ->label('Preço')
                    ->required()
                    ->numeric()
                    ->step('0.01'),
                Forms\Components\TimePicker::make('horario')
                    ->required()
                    ->seconds(false)
                    ->label("Horario"),
                Forms\Components\TextInput::make('endereco')
                    ->required()
                    ->columnSpan(2)
                    ->maxLength(255)
                    ->label("Endereço"),
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
                Tables\Columns\TextColumn::make('horario')
                    ->label('Horario')
                    ->sortable(),
                Tables\Columns\TextColumn::make('endereco')
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

                        DB::statement("UPDATE {$prefix}.passeio SET endereco = :endereco, horario = :horario WHERE id = :id", [
                            'endereco' => $data['endereco'],
                            'horario' => $data['horario'],
                            'id' => $record->id,
                        ]);
                    });
                }),
                Tables\Actions\DeleteAction::make()
                ->using(function ($record) {
                    $prefix = config('database.connections.pgsql.search_path');
                    return DB::transaction(function () use ($record, $prefix) {
                        DB::statement("DELETE FROM {$prefix}.passeio WHERE id = :id", [
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
            'index' => Pages\ManagePasseios::route('/'),
        ];
    }
}
