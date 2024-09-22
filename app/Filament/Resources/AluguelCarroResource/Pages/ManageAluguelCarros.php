<?php

namespace App\Filament\Resources\AluguelCarroResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\AluguelCarroResource;

class ManageAluguelCarros extends ManageRecords
{
    protected static string $resource = AluguelCarroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->using(function (array $data, string $model) {
                $prefix = config('database.connections.pgsql.search_path');
                return DB::transaction(function () use ($data, $model, $prefix) {
                    $servicoAdicionalId = DB::selectOne("
                        INSERT INTO {$prefix}.servicoadicional (nome, descricao, preco)
                        VALUES (:nome, :descricao, :preco)
                        RETURNING id
                        ", [
                            'nome' => $data['nome'],
                            'descricao' => $data['descricao'],
                            'preco' => $data['preco'],
                        ])->id;


                    DB::statement("INSERT INTO $prefix.aluguelcarro (datainicio, datafim, placa, id) VALUES ('{$data['datainicio']}', '{$data['datafim']}', '{$data['placa']}', $servicoAdicionalId)");
                });
            }),
        ];
    }
}
