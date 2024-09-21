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
        DB::unprepared("CREATE TABLE TRABALHO_KAYANZIN.Cliente (
                ID SERIAL PRIMARY KEY,
                Nome VARCHAR(255) NOT NULL,
                Contato VARCHAR(255),
                Identidade VARCHAR(11) UNIQUE NOT NULL
            ); -- Tabela de cliente


            -- Tabela AgenteViagem
            CREATE TABLE TRABALHO_KAYANZIN.AgenteViagem (
                ID SERIAL PRIMARY KEY,
                Nome VARCHAR(255) NOT NULL,
                Contato VARCHAR(255),
                Comissao DECIMAL(10, 2)
            );


            -- Tabela CompanhiaAerea
            CREATE TABLE TRABALHO_KAYANZIN.CompanhiaAerea (
                ID SERIAL PRIMARY KEY,
                Nome VARCHAR(255) NOT NULL,
                Sede VARCHAR(255)
            );


            -- Tabela ServicoAdicional
            CREATE TABLE TRABALHO_KAYANZIN.ServicoAdicional (
                ID SERIAL PRIMARY KEY,
                Nome VARCHAR(255) NOT NULL,
                Descricao TEXT,
                Preco DECIMAL(10, 2) NOT NULL CHECK (Preco >= 0)
            );


            -- Tabela Passeio
            CREATE TABLE TRABALHO_KAYANZIN.Passeio (
                ID INT REFERENCES TRABALHO_KAYANZIN.ServicoAdicional(ID) ON DELETE CASCADE PRIMARY KEY ,
                Horario TIME NOT NULL,
                Endereco VARCHAR(255) NOT NULL
            );


            -- Tabela AluguelCarro
            CREATE TABLE TRABALHO_KAYANZIN.AluguelCarro (
                ID INT REFERENCES TRABALHO_KAYANZIN.ServicoAdicional(ID) ON DELETE CASCADE PRIMARY KEY ,
                DataInicio DATE NOT NULL CHECK (DataInicio > CURRENT_DATE),
                DataFim DATE NOT NULL CHECK (DataFim > DataInicio),
                Placa VARCHAR(50) NOT NULL
            );


            -- Tabela Academia
            CREATE TABLE TRABALHO_KAYANZIN.Academia (
                ID INT REFERENCES TRABALHO_KAYANZIN.ServicoAdicional(ID) ON DELETE CASCADE PRIMARY KEY ,
                Endereco VARCHAR(255) NOT NULL,
                HorarioFuncionamento VARCHAR(255) NOT NULL
            );


            -- Tabela Voo
            CREATE TABLE TRABALHO_KAYANZIN.Voo (
                ID INT REFERENCES TRABALHO_KAYANZIN.ServicoAdicional(ID) ON DELETE CASCADE PRIMARY KEY,
                HorarioPartida TIME NOT NULL,
                HorarioChegada TIME NOT NULL,
                CompanhiaAereaID INT REFERENCES TRABALHO_KAYANZIN.CompanhiaAerea(ID) NOT NULL
            );


            -- Tabela Hotel
            CREATE TABLE TRABALHO_KAYANZIN.Hotel (
                ID SERIAL PRIMARY KEY,
                Nome VARCHAR(255) NOT NULL,
                Endereco VARCHAR(255) NOT NULL
            );


            -- Tabela TipoPacote
            CREATE TABLE TRABALHO_KAYANZIN.TipoPacote (
                ID SERIAL PRIMARY KEY,
                Nome VARCHAR(255) NOT NULL,
                Duracao INT NOT NULL,
                Tematica VARCHAR(255)
            );


            -- Tabela PacoteViagem
            CREATE TABLE TRABALHO_KAYANZIN.PacoteViagem (
                ID SERIAL PRIMARY KEY,
                Destino VARCHAR(255) NOT NULL,
                DataDePartida DATE NOT NULL CHECK (DataDePartida > CURRENT_DATE),
                DataDeRetorno DATE NOT NULL CHECK (DataDeRetorno > DataDePartida),
                Preco DECIMAL(10, 2) NOT NULL CHECK (Preco > 0),
                TipoPacoteID INT REFERENCES TRABALHO_KAYANZIN.TipoPacote(ID) NOT NULL,
                CapacidadeMaxima INT NOT NULL CHECK (CapacidadeMaxima > 0) DEFAULT 5
            );


            -- Tabela Reserva
            CREATE TABLE TRABALHO_KAYANZIN.Reserva (
                ID SERIAL PRIMARY KEY,
                ClienteID INT REFERENCES TRABALHO_KAYANZIN.Cliente(ID) NOT NULL,
                PacoteViagemID INT REFERENCES TRABALHO_KAYANZIN.PacoteViagem(ID) NOT NULL,
                AgenteViagemID INT REFERENCES TRABALHO_KAYANZIN.AgenteViagem(ID) NOT NULL,
                DataReserva DATE NOT NULL,
                Status VARCHAR(50) NOT NULL check (Status in ('Pendente', 'Confirmada', 'Cancelada')) DEFAULT 'Pendente'   
            );


            -- Tabela Pagamento
            CREATE TABLE TRABALHO_KAYANZIN.Pagamento (
                ID SERIAL PRIMARY KEY,
                Valor DECIMAL(10, 2) NOT NULL CHECK (Valor > 0),
                MetodoPagamento VARCHAR(50) NOT NULL CHECK (MetodoPagamento in ('Cartão de Crédito', 'Cartão de Débito', 'Boleto', 'PIX', 'Dinheiro')),
                DataPagamento DATE NOT NULL,
                ReservaID INT REFERENCES TRABALHO_KAYANZIN.Reserva(ID)
            );


            -- Tabela AvaliacaoCliente
            CREATE TABLE TRABALHO_KAYANZIN.AvaliacaoCliente (
                ID SERIAL PRIMARY KEY,
                Nota INT NOT NULL CHECK (Nota >= 0 AND Nota <= 5),
                Comentario TEXT,
                ReservaID INT REFERENCES TRABALHO_KAYANZIN.Reserva(ID) ON DELETE CASCADE NOT NULL
            );


            -- Tabela DestinoTuristico
            CREATE TABLE TRABALHO_KAYANZIN.DestinoTuristico (
                ID SERIAL PRIMARY KEY,
                Nome VARCHAR(255) NOT NULL,
                Descricao TEXT,
                Localizacao VARCHAR(255)
            );


            -- Tabela ReservaServicoAdicional
            CREATE TABLE TRABALHO_KAYANZIN.ReservaServicoAdicional (
                ReservaID INT REFERENCES TRABALHO_KAYANZIN.Reserva(ID) ON DELETE CASCADE,
                ServicoAdicionalID INT REFERENCES TRABALHO_KAYANZIN.ServicoAdicional(ID),
                PRIMARY KEY (ReservaID, ServicoAdicionalID)
            );

            -- Tabela DestinoTuristicoPacoteViagem
            CREATE TABLE TRABALHO_KAYANZIN.DestinoTuristicoPacoteViagem (
                DestinoTuristicoID INT REFERENCES TRABALHO_KAYANZIN.DestinoTuristico(ID),
                PacoteViagemID INT REFERENCES TRABALHO_KAYANZIN.PacoteViagem(ID) ON DELETE CASCADE,
                PRIMARY KEY (DestinoTuristicoID, PacoteViagemID)
            );


            -- Tabela HotelPacoteViagem
            CREATE TABLE TRABALHO_KAYANZIN.HotelPacoteViagem (
                HotelID INT REFERENCES TRABALHO_KAYANZIN.Hotel(ID),
                PacoteViagemID INT REFERENCES TRABALHO_KAYANZIN.PacoteViagem(ID) ON DELETE CASCADE,
                PRIMARY KEY (HotelID, PacoteViagemID)
            );"
        );      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
