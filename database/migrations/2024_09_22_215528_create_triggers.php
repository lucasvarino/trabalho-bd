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
        DB::unprepared("CREATE OR REPLACE FUNCTION verifica_capacidade_pacote()
        RETURNS TRIGGER AS $$
        DECLARE
            capacidade_maxima INT;
            qtd_reservas_atuais INT;
        BEGIN
            SELECT CapacidadeMaxima INTO capacidade_maxima
            FROM trabalho_kayanzin.PacoteViagem
            WHERE id = NEW.pacoteViagemId;

            SELECT COUNT(*) INTO qtd_reservas_atuais
            FROM trabalho_kayanzin.Reserva
            WHERE pacoteViagemId = NEW.pacoteViagemId
            AND status <> 'Cancelada';

            IF qtd_reservas_atuais >= capacidade_maxima THEN
                RAISE EXCEPTION 'A capacidade máxima do pacote foi atingida. Não é possível adicionar mais reservas.';
            END IF;

            RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
            
            
        CREATE TRIGGER trigger_verifica_capacidade_pacote
        BEFORE INSERT ON trabalho_kayanzin.Reserva
        FOR EACH ROW
        EXECUTE FUNCTION verifica_capacidade_pacote();

        Create or replace function trabalho_kayanzin.verificaReserva() returns trigger as $$
        Begin
            IF (SELECT status FROM trabalho_kayanzin.reserva WHERE id = NEW.reservaId) <> 'Confirmada' THEN
                RAISE EXCEPTION 'A avaliação só pode ser feita para reservas confirmadas.';
            END IF;

            RETURN NEW;
        end;
        $$ LANGUAGE plpgsql;

        create Trigger trigger_verifica_status_reserva
            before insert on trabalho_kayanzin.avaliacaocliente
            for each row
            execute procedure trabalho_kayanzin.verificaReserva();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trigger_verifica_capacidade_pacote ON trabalho_kayanzin.Reserva;");
        DB::unprepared("DROP FUNCTION IF EXISTS verifica_capacidade_pacote();");
        DB::unprepared("DROP TRIGGER IF EXISTS trigger_verifica_status_reserva ON trabalho_kayanzin.avaliacaocliente;");
        DB::unprepared("DROP FUNCTION IF EXISTS trabalho_kayanzin.verificaReserva();");
    }
};
