<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterTransferContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_transfer_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contract');
            $table->string('immobile_code');
            $table->string('address');
            $table->string('neighborhood');
            $table->decimal('value', 15, 2);
            $table->string('owner');
            $table->string('owner_phone_residential', 50)->nullable();
            $table->string('owner_phone_commercial', 50)->nullable();
            $table->string('owner_cell_phone', 50)->nullable();
            $table->string('owner_email')->nullable();
            $table->string('requester_name');
            $table->string('requester_phone_01', 50);
            $table->string('requester_phone_02', 50)->nullable();
            $table->string('requester_phone_03', 50)->nullable();
            $table->string('requester_email')->nullable();
            $table->date('transfer_date');
            $table->string('status', 10)->default('p')->comment('(p) pending, (r) resolved, (c) canceled');
            $table->string('new_contract')->nullable();
            $table->date('end_process')->nullable();
            $table->integer('reason_id');
            $table->integer('responsible_transfer_id');
            $table->text('observation')->nullable();
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
        Schema::dropIfExists('register_transfer_contracts');
    }
}
