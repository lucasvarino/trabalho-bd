<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE INDEX idx_reserva_status ON trabalho_kayanzin.reserva (status);

        CREATE INDEX idx_reserva_agente_viagem_id ON trabalho_kayanzin.reserva (agenteviagemid);

        CREATE INDEX idx_reserva_cliente_id ON trabalho_kayanzin.reserva (clienteid);

        CREATE INDEX idx_reserva_pacote_viagem_id ON trabalho_kayanzin.reserva (pacoteviagemid);


        -- /Criação de indices tabela avaliacaocliente/

        CREATE INDEX idx_avaliacao_reserva_id ON trabalho_kayanzin.avaliacaocliente (reservaid);


        -- /Criação de indices tabela pacoteviagem/

        CREATE INDEX idx_tipo_pacote_id ON trabalho_kayanzin.pacoteviagem(tipopacoteid);

        -- /Criação de indices tabela pagamento/

        CREATE INDEX idx_reserva_id ON trabalho_kayanzin.pagamento(reservaid);

        create index idx_cliente_nome on trabalho_kayanzin.cliente (nome);
        create index idx_reserva_clienteid on trabalho_kayanzin.reserva (clienteid);


        -- /Criação de indices tabela voo/

        CREATE INDEX idx_companhia_aerea_id ON trabalho_kayanzin.voo(companhiaaereaid);");
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP INDEX IF EXISTS idx_reserva_status;

        DROP INDEX IF EXISTS idx_reserva_agente_viagem_id;

        DROP INDEX IF EXISTS idx_reserva_cliente_id;

        DROP INDEX IF EXISTS idx_reserva_pacote_viagem_id;

        DROP INDEX IF EXISTS idx_cliente_nome;

        DROP INDEX IF EXISTS idx_reserva_clienteid;

        DROP INDEX IF EXISTS idx_avaliacao_reserva_id;

        DROP INDEX IF EXISTS idx_tipo_pacote_id;

        DROP INDEX IF EXISTS idx_reserva_id;

        DROP INDEX IF EXISTS idx_companhia_aerea_id;
        ");
    }
};
