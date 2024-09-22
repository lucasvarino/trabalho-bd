<?php

namespace App\Filament\Resources\AgenteViagemResource\Pages;

use App\Filament\Resources\AgenteViagemResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAgenteViagems extends ManageRecords
{
    protected static string $resource = AgenteViagemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
