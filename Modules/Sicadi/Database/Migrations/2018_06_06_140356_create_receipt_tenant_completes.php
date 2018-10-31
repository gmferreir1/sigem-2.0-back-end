<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptTenantCompletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sicadi')->create('receipt_tenant_completes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('due_date');
            $table->integer('receipt_tenant_id');
            $table->date('payment_date')->nullable()->comment('Data do pagamento');
            $table->decimal('value', 15, 2)->nullable()->comment('VALOR');
            $table->decimal('value_base', 15, 2)->nullable()->comment('Valor base');
            $table->decimal('value_pay', 15, 2)->nullable()->comment('Valor pago');
            $table->decimal('value_rent', 15, 2)->nullable()->comment('Valor aluguel');
            $table->integer('month_serie')->comment('Mês parcela');
            $table->integer('contract_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sicadi')->dropIfExists('receipt_tenant_completes');
    }
}
