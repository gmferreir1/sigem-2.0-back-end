<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id_sicadi')->nullable();
            $table->string('client_code')->nullable();
            $table->string('client_name')->nullable();

            $table->integer('type_client')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('sex', 5)->nullable();
            $table->string('civil_state')->nullable();
            $table->string('rg')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->integer('spouse_code')->comment('Código cônjuge')->nullable();
            $table->string('company')->comment('Empresa')->nullable();
            $table->integer('responsible_company')->comment('Responsável pela empresa')->nullable();

            $table->string('cic_cgc')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sicadi')->dropIfExists('s_complete_clients');
    }
}
