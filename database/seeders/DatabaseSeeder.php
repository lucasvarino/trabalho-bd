<?php

namespace Database\Seeders;

use App\Models\Voo;
use App\Models\User;
use App\Models\Passeio;
use App\Models\Academia;
use App\Models\AluguelCarro;
use App\Models\PacoteViagem;
use App\Models\Reserva;
use Illuminate\Database\Seeder;
use App\Models\ServicoAdicional;
use Database\Factories\HotelFactory;
use Database\Factories\ClienteFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\PagamentoFactory;
use Database\Factories\TipoPacoteFactory;
use Database\Factories\AgenteViagemFactory;
use Database\Factories\CompanhiaAereaFactory;
use Database\Factories\AvaliacaoClienteFactory;
use Database\Factories\DestinoTuristicoFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Criar 100 Clientes
        $clientes = ClienteFactory::new()->count(100)->create();

        // Criar 10 Tipos de Pacotes
        $tipoPacote = TipoPacoteFactory::new()->count(10)->create();

        // Criar 10 Hotel
        $hoteis = HotelFactory::new()->count(10)->create();

        // Criar 10 destinos turisticos
        $destinos = DestinoTuristicoFactory::new()->count(10)->create();

        // Criar 10 agentes de viagens
        $agentes = AgenteViagemFactory::new()->count(10)->create(); 

        // Criar 10 companhias aéreas
        $companhias = CompanhiaAereaFactory::new()->count(10)->create();

        // Criar 100 Serviços Adicionais de forma ordenada
        $servicos = ServicoAdicional::factory()
            ->count(100)
            ->create();
        
        $servicos->each(function ($servico, $index) use ($companhias) {
            if($index % 4 === 0){
                Voo::factory(['id' => $servico->id, "companhiaaereaid" => $companhias->random()->id])
                    ->create();
                $servico->update(['nome' => 'Voo ' . $servico->id]);
            }else if($index % 4 === 1){
                Academia::factory(['id' => $servico->id])->create();
                $servico->update(['nome' => 'Academia ' . $servico->id]);
            }else if($index % 4 === 2){
                AluguelCarro::factory(['id' => $servico->id])->create();
                $servico->update(['nome' => 'AluguelCarro ' . $servico->id]);
            }else{
                Passeio::factory(['id' => $servico->id])->create();
                $servico->update(['nome' => 'Passeio ' . $servico->id]);
            }
        });

        // Criar 10 pacotes de viagem
        $pacotes = PacoteViagem::factory()
            ->count(10)
            ->sequence(
                fn ($sequence) => [
                    'tipopacoteid' => $tipoPacote->random()->id,
                ]
            )
            ->create();
        
        //Criando relações com os hoteis
        $pacotes->each(function ($pacote) use ($hoteis, $destinos) {
            $hoteis->random()->pacotesViagem()->attach($pacote);
            $destinos->random()->pacotesViagem()->attach($pacote);
        });

        $reservas = Reserva::factory()
            ->count(100)
            ->sequence(
                fn ($sequence) => [
                    'clienteid' => $clientes->random()->id,
                    'pacoteviagemid' => $pacotes->random()->id,
                    'agenteviagemid' => $agentes->random()->id,
                ]
            )
            ->create();
        
        $reservas->each(function ($reserva) use ($servicos) {
            $qtd_servicos = rand(0, 5);
            if($qtd_servicos > 0)
                $reserva->servicosAdicionais()->attach($servicos->random($qtd_servicos));

            if($reserva->status != 'Cancelada'){
                PagamentoFactory::new()->create([
                    'reservaid' => $reserva->id,
                ]);
            }

            if($reserva->status == 'Confirmada'){
                AvaliacaoClienteFactory::new()->create([
                    'reservaid' => $reserva->id,
                ]);
            }
        });
        

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
