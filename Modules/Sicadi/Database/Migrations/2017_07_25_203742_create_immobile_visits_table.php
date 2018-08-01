<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImmobileVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('immobile_visits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('immobile_id')->nullable();
            $table->string('immobile_code')->nullable();
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('building_name')->nullable();
            $table->string('condominium_name')->nullable();
            $table->string('type_immobile_id')->nullable();
            $table->string('value_rent')->nullable();
            $table->string('available_rental')->nullable();
            $table->string('rent', 50)->nullable();
            $table->string('type_immobile')->nullable();
            $table->integer('visit_id')->nullable();
            $table->text('commentary')->nullable();
            $table->string('type_visit', 10)->nullable();
            $table->string('visit_reserve', 10)->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sicadi')->dropIfExists('immobile_visits');
    }
}
