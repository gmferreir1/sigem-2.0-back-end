<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dead_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('termination_id')->nullable();
            $table->string('contract');
            $table->date('termination_date');
            $table->integer('cashier')->comment('caixa');
            $table->integer('file')->comment('arquivo');
            $table->string('type_release')->comment('justice or rent');
            $table->integer('status')->comment('1 - arquivado 2-cancelado');
            $table->integer('rp_last_action');
            $table->integer('year_release');
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
        Schema::dropIfExists('dead_files');
    }
}
