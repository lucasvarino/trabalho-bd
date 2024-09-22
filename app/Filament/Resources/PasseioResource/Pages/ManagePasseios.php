<?php

namespace App\Filament\Resources\PasseioResource\Pages;

use App\Filament\Resources\PasseioResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\DB;

class ManagePasseios extends ManageRecords
{
    protected static string $resource = PasseioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->using(function (array $data, string $model) {
                $prefix = config('database.connections.pgsql.search_path');
                return DB::transaction(function () use ($data, $prefix) {
                    $servicoAdicionalId = DB::selectOne("
                        INSERT INTO {$prefix}.servicoadicional (nome, descricao, preco)
                        VALUES (:nome, :descricao, :preco)
                        RETURNING id
                        ", [
                            'nome' => $data['nome'],
                            'descricao' => $data['descricao'],
                            'preco' => $data['preco'],
                        ])->id;


                    DB::statement("INSERT INTO $prefix.passeio (horario, endereco, id) VALUES ('{$data['horario']}', '{$data['endereco']}', $servicoAdicionalId)");
                });
            }),
        ];
    }
}
