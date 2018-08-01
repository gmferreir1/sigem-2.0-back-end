<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInactiveContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('inactive_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contract_code')->nullable();
            $table->date('date_primary_contract');
            $table->date('init_date_current_contract')->nullable();
            $table->integer('contract_time')->nullable();
            $table->string('value_rent')->nullable();
            $table->date('date_cancellation')->nullable();
            $table->string('immobile_id')->nullable();
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('building_name')->nullable();
            $table->string('condominium_name')->nullable();
            $table->string('type_immobile')->nullable();
            $table->integer('type_immobile_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sicadi')->dropIfExists('inactive_contracts');
    }
}
