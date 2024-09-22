<?php

namespace App\Filament\Resources\ReservaResource\Pages;

use App\Filament\Resources\ReservaResource;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;

class ManageReservas extends ManageRecords
{
    protected static string $resource = ReservaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->using(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make("Todas reservas"),
            'active' => Tab::make("Reservas confirmadas")
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'Confirmada')),

            'pendants' => Tab::make("Reservas pendente")
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'Pendente')),

            'inactive ' => Tab::make("Reservas canceladas")
            ->modifyQueryUsing(fn ($query) => $query->where('status', 'Cancelada')),
        ];
    }
}
