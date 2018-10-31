<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminationContractHistoricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termination_contract_historics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id');
            $table->text('historic');
            $table->integer('rp_last_action');
            $table->string('type_action')->default('system_action')->comment('Tipo de ação (user_action)->historico gerado pelo usuário (system_action)->ações feitas pela usuário');
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
        Schema::dropIfExists('termination_contract_historics');
    }
}
