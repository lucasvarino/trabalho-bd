<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClientes extends ManageRecords
{
    protected static string $resource = ClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $data['identidade'] = preg_replace('/[^0-9]/', '', $data['identidade']);
                return $data;
            }),
        ];
    }
}
