<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminationImmobileReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termination_immobile_releases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('immobile_code');
            $table->date('inactivate_date');
            $table->integer('rp_receive')->unsigned()->comment('Quem vai receber o imóvel da rescisão');
            $table->date('date_send')->comment('Data que o imóvel foi liberado da rescisão');
            $table->integer('site')->default(0);
            $table->integer('picture_site')->default(0);
            $table->integer('internal_picture')->default(0);
            $table->text('observation')->nullable();
            $table->date('advertisement')->nullable()->comment('Data do anuncio no site');
            $table->integer('termination_id')->comment('Id da rescisão de contrato');
            $table->integer('rp_release')->unsigned();
            $table->integer('rp_end_process')->nullable();
            $table->string('status')->default('p')->comment('(p) pendente, (f) finalizado');
            $table->integer('rp_last_action')->unsigned();
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
        Schema::dropIfExists('termination_immobile_releases');
    }
}
