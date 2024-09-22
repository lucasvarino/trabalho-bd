<?php

namespace App\Filament\Resources\PacoteViagemResource\Pages;

use App\Filament\Resources\PacoteViagemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPacoteViagem extends EditRecord
{
    protected static string $resource = PacoteViagemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
