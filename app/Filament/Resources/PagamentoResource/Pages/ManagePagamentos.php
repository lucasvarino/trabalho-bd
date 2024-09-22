<?php

namespace App\Filament\Resources\PagamentoResource\Pages;

use App\Filament\Resources\PagamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;

class ManagePagamentos extends ManageRecords
{
    protected static string $resource = PagamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make("Todos os pagamentos"),
            'pix' => Tab::make("Pagamentos no PIX")
                ->modifyQueryUsing(fn ($query) => $query->where('metodopagamento', 'PIX')),
            'boleto' => Tab::make("Pagamentos no Boleto")
                ->modifyQueryUsing(fn ($query) => $query->where('metodopagamento', 'Boleto')),
            'cartao-credito' => Tab::make("Pagamentos no Cartão Crédito")
                ->modifyQueryUsing(fn ($query) => $query->where('metodopagamento', 'Cartão de Crédito')),
            'dinheiro' => Tab::make("Pagamentos em Dinheiro")
                ->modifyQueryUsing(fn ($query) => $query->where('metodopagamento', 'Dinheiro')),
            'cartao-debito' => Tab::make("Pagamentos no Cartão Débito")
                ->modifyQueryUsing(fn ($query) => $query->where('metodopagamento', 'Cartão de Débito')),
        ];
    }
}
