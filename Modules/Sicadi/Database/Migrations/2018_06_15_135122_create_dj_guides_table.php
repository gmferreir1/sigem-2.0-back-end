<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDjGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('dj_guides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dj_id');
            $table->date('date_send')->comment('Data do envio para a justiça');
            $table->integer('receipt_id')->comment('Identificador do recibo');
            $table->decimal('value', 15, 2)->nullable()->comment('Valor recibo');
            $table->date('date_exit')->nullable()->comment('Data de saída da justiça');
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
        Schema::dropIfExists('dj_guides');
    }
}
