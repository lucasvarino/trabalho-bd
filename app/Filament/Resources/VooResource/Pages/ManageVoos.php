<?php

namespace App\Filament\Resources\VooResource\Pages;

use App\Filament\Resources\VooResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\DB;

class ManageVoos extends ManageRecords
{
    protected static string $resource = VooResource::class;

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

                        DB::statement("INSERT INTO $prefix.voo (horariopartida, horariochegada, companhiaaereaid, id) VALUES ('{$data['horariopartida']}', '{$data['horariochegada']}', '{$data['companhiaaereaid']}', $servicoAdicionalId)");
                    });
                }),
        ];
    }
}
