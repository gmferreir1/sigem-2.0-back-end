<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImmobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('immobiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('immobile_id')->nullable();
            $table->string('immobile_code')->nullable();
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->integer('condominium_id')->nullable();
            $table->string('building_name')->nullable();
            $table->string('condominium_name')->nullable();
            $table->string('condominium_address')->nullable();
            $table->string('condominium_syndicate')->nullable();
            $table->string('condominium_neighborhood')->nullable();
            $table->string('condominium_city')->nullable();
            $table->string('condominium_state')->nullable();
            $table->string('condominium_cep')->nullable();
            $table->string('condominium_email')->nullable();
            $table->integer('type_immobile_id')->nullable();
            $table->string('value_rent')->nullable();
            $table->string('available_rental', 50)->nullable();
            $table->string('rent', 50)->nullable();
            $table->integer('owner_code')->nullable();
            $table->string('type_immobile')->nullable();
            $table->string('type_occupation')->nullable();
            $table->text('survey_observation')->nullable();
            $table->string('iptu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sicadi')->dropIfExists('immobiles');
    }
}
