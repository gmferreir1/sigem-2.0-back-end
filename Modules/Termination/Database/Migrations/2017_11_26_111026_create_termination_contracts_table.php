<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminationContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termination_contracts', function (Blueprint $table) {
            $table->increments('id');
            //dados imovel
            $table->string('contract');
            $table->string('immobile_code');
            $table->string('address');
            $table->string('neighborhood');
            $table->string('value');
            $table->string('immobile_type');
            $table->string('type_location');
            //dados proprietário
            $table->string('owner');
            $table->string('owner_phone_residential')->nullable();
            $table->string('owner_phone_commercial')->nullable();
            $table->string('owner_cell_phone')->nullable();
            $table->string('owner_email')->nullable();
            //dados inquilino
            $table->string('tenant');
            $table->string('tenant_phone_residential')->nullable();
            $table->string('tenant_phone_commercial')->nullable();
            $table->string('tenant_cell_phone')->nullable();
            $table->string('tenant_email')->nullable();
            //dados da inativação
            $table->date('termination_date');
            $table->date('end_process')->nullable();
            $table->string('status', 20);
            $table->string('type_register', 100)->comment('Tipo de lançamento, transferencia ou rescisão');
            $table->integer('reason_id')->unsigned();
            $table->string('rent_again', 5);
            $table->integer('destination_id')->unsigned()->nullable();
            $table->string('caveat', 10)->comment('ressalva (y) - yes(sim), (n) - no(nao)');
            $table->integer('surveyor_id')->nullable()->unsigned();
            $table->boolean('survey_release')->default(false);
            $table->integer('rp_per_inactive')->unsigned();
            $table->integer('rp_register_sector')->unsigned()->nullable();
            $table->string('new_contract_code')->nullable();
            $table->integer('rp_last_action')->unsigned();
            $table->text('observation')->nullable();
            $table->boolean('archive')->default(false);
            $table->boolean('release_immobile')->default(false);
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
        Schema::dropIfExists('termination_contracts');
    }
}
