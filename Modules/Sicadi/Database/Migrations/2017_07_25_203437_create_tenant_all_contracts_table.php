<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantAllContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('tenant_all_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id');
            $table->integer('client_id_sicadi')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_code')->nullable();
            $table->string('contract_code')->nullable();
            $table->integer('immobile_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sicadi')->dropIfExists('tenant_all_contracts');
    }
}
