<?php

namespace App\Filament\Resources\AvaliacaoClienteResource\Pages;

use App\Filament\Resources\AvaliacaoClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAvaliacaoClientes extends ManageRecords
{
    protected static string $resource = AvaliacaoClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
           
        ];
    }
}
