<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerActionsDatabaseUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_actions_database_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_name');
            $table->integer('rp_action');
            $table->string('status')->nullable()->comment('p -> process(processo de atualização, up -> updated(atualizada))');
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
        Schema::dropIfExists('manager_actions_database_updates');
    }
}
