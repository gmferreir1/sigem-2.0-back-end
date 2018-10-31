<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImmobileCapturedReportListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immobile_captured_report_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('immobile_code');
            $table->string('address');
            $table->string('neighborhood');
            $table->decimal('value', 15, 2);
            $table->string('owner');
            $table->integer('type_immobile');
            $table->string('type_location');
            $table->date('captured_date');
            $table->integer('responsible');
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
        Schema::dropIfExists('immobile_captured_report_lists');
    }
}
