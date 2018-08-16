<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterReserveContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_reserve_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('immobile_code');
            $table->string('address');
            $table->string('neighborhood');
            $table->decimal('value', 15, 2);
            $table->decimal('value_negotiated', 15, 2);
            $table->string('type_location', 5);
            $table->integer('immobile_type');
            $table->integer('code_reserve')->nullable();
            $table->integer('year_reserve')->nullable();
            $table->date('date_reserve');
            $table->date('prevision');
            $table->date('conclusion')->nullable()->comment('Data da entrega das chaves e conclusão do processo quando cancelado');
            $table->string('situation', 10)->comment('r = reserva, d = documentação, a = analise, cd = cadastro, p = pendente, as = assinado, ap = assinado com pendencias, af = atividades finais, c = cancelado');
            $table->string('contract')->nullable();
            $table->date('date_init_contract')->nullable();
            $table->integer('deadline')->nullable();
            $table->integer('taxa')->nullable();
            $table->text('observation')->nullable();
            $table->string('origin_city')->nullable();
            $table->string('origin_state', 15)->nullable();
            $table->string('finality', 15)->nullable();
            $table->string('client_name');
            $table->string('client_cpf')->nullable();
            $table->string('client_rg')->nullable();
            $table->string('client_profession')->nullable();
            $table->string('client_company')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_neighborhood')->nullable();
            $table->string('client_city')->nullable();
            $table->string('client_state', 50)->nullable();
            $table->string('client_phone_01', 50);
            $table->string('client_phone_02', 50)->nullable();
            $table->string('client_phone_03', 50)->nullable();
            $table->string('client_email')->nullable();
            $table->integer('attendant_register_id');
            $table->integer('attendant_reception_id');
            $table->string('email_owner')->nullable();
            $table->string('email_tenant')->nullable();
            $table->string('email_condominium')->nullable();
            $table->integer('rp_last_action');
            $table->integer('id_reason_cancel')->nullable();
            $table->text('reason_cancel_detail')->nullable();
            $table->date('end_process')->nullable()->comment('Data da finalização do processo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_reserve_contracts');
    }
}
