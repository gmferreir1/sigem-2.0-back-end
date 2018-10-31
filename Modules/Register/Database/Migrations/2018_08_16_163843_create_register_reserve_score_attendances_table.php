<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterReserveScoreAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_reserve_score_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attendant_id');
            $table->integer('score');
            $table->integer('rp_last_action');
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
        Schema::dropIfExists('register_reserve_score_attendances');
    }
}
