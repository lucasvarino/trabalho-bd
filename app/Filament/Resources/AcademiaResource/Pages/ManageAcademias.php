<?php

namespace App\Filament\Resources\AcademiaResource\Pages;

use App\Filament\Resources\AcademiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\DB;

class ManageAcademias extends ManageRecords
{
    protected static string $resource = AcademiaResource::class;


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


                        DB::statement("INSERT INTO $prefix.academia (endereco, horariofuncionamento, id) VALUES ('{$data['endereco']}', '{$data['horariofuncionamento']}', $servicoAdicionalId)");
                    });
                }),
        ];
    }
}
