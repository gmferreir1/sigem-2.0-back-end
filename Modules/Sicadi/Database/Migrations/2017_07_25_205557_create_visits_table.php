<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visit_id');
            $table->string('client_name', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('neighborhood', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip_code', 255)->nullable();
            $table->string('phone_commercial', 50)->nullable();
            $table->string('phone_residential', 50)->nullable();
            $table->string('cell_phone', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->date('date_register');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sicadi')->dropIfExists('visits');
    }
}
