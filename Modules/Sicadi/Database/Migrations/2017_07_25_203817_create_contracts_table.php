<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->nullable();
            $table->string('contract_code')->nullable();
            $table->string('tenant_name')->nullable();
            $table->date('date_primary_contract')->nullable();
            $table->date('init_date_current_contract')->nullable();
            $table->integer('contract_time')->nullable();
            $table->string('value_rent')->nullable();
            $table->string('immobile_id')->nullable();
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('building_name')->nullable();
            $table->string('condominium_name')->nullable();
            $table->string('type_immobile')->nullable();
            $table->integer('type_immobile_id')->nullable();
            $table->date('termination_date')->nullable();
            $table->date('last_adjustment')->comment('Data do ultimo reajuste de aluguel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sicadi')->dropIfExists('contracts');
    }
}
