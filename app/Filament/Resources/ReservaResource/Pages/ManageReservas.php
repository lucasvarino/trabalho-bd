<?php

namespace App\Filament\Resources\ReservaResource\Pages;

use App\Filament\Resources\ReservaResource;
use App\Models\PacoteViagem;
use App\Models\Reserva;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;

class ManageReservas extends ManageRecords
{
    protected static string $resource = ReservaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function(array $data) {
                    $clienteId = $data['clienteid'];
                    $pacoteViagemId = $data['pacoteviagemid'];

                    // Obter o pacote viagem e suas datas
                    $pacoteViagem = PacoteViagem::find($pacoteViagemId);
                    if ($pacoteViagem) {
                        $dataInicio = $pacoteViagem->datadepartida;
                        $dataFim = $pacoteViagem->dataderetorno;
                        
                        // Verificar se já existe uma reserva no mesmo período
                        $reservaExistente = Reserva::where('clienteid', $clienteId)
                            ->whereHas('pacoteViagem', function($query) use ($dataInicio, $dataFim) {
                                $query->where(function($query) use ($dataInicio, $dataFim) {
                                    $query->whereBetween('datadepartida', [$dataInicio, $dataFim])
                                        ->orWhereBetween('dataderetorno', [$dataInicio, $dataFim])
                                        ->orWhere(function($query) use ($dataInicio, $dataFim) {
                                            $query->where('datadepartida', '<=', $dataInicio)
                                                    ->where('dataderetorno', '>=', $dataFim);
                                        });
                                });
                            })->exists();

                        if ($reservaExistente) {
                            Notification::make()
                                ->danger()
                                ->title('Já existe uma reserva para o cliente neste período')
                                ->color('danger')
                                ->send();
                            return;
                        }
                        // Criar a reserva
                        $reserva = Reserva::create([
                            'clienteid' => $clienteId,
                            'pacoteviagemid' => $pacoteViagemId,
                            'agenteviagemid' => $data['agenteviagemid'],
                            'status' => $data['status'],
                            'datareserva' => $data['datareserva'],
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Reserva criada com sucesso')
                            ->send();

                        return $reserva;
                    }
                })->successNotification(null),
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
