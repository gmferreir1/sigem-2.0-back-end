<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialContractCelebratedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_contract_celebrateds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reserve_id');
            $table->string('contract');
            $table->string('immobile_code');
            $table->string('address');
            $table->string('neighborhood');
            $table->string('owner_name');
            $table->date('conclusion');
            $table->string('type_contract', 10)->nullable();
            $table->string('ticket', 10)->nullable();
            $table->string('tx_contract', 10)->nullable();
            $table->string('bank_expense', 10)->nullable();
            $table->string('subscription_iptu')->nullable();
            $table->integer('period_contract')->nullable();
            $table->date('delivery_key')->nullable();
            $table->integer('rp_last_action')->nullable();
            $table->string('status', 10)->default('p')->comment('p: (pending) pendente, r: (release) lançado');
            $table->string('status_iptu', 10)->default('p')->comment('p: (pending) pendente, r: (release) lançado');
            $table->string('status_tcrs', 10)->default('p')->comment('p: (pending) pendente, r: (release) lançado');
            $table->date('due_date_rent')->nullable()->comment('Data de vencimento do aluguel');
            $table->string('loyalty_discount', 10)->nullable()->comment('Desconto de fidelidade s->(sim) n->(nao)');
            $table->date('sync')->nullable()->comment('Quando o usuário clica no botão de sincronizar a tabela');
            $table->integer('rp_release')->comment('Responsável pela liberação da reserva')->nullable();
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
        Schema::dropIfExists('financial_contract_celebrateds');
    }
}
