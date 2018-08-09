<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminationRentAccessoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termination_rent_accessories', function (Blueprint $table) {
            $table->increments('id');

            $table->text('fine_termination')->nullable()->comment('multa rescisoria');
            $table->string('fine_termination_type_debit', 5)->nullable()->comment('credito ou debito');
            $table->decimal('fine_termination_value_debit', 15, 2)->nullable()->comment('valor do credito ou debito');

            $table->text('condominium')->nullable()->comment('condominio');
            $table->string('condominium_type_debit', 5)->nullable()->comment('credito ou debito');
            $table->decimal('condominium_value_debit', 15, 2)->nullable()->comment('valor do credito ou debito');

            $table->text('copasa')->nullable();
            $table->decimal('copasa_value_debit', 15, 2)->nullable()->comment('valor do credito ou debito');

            $table->text('cemig')->nullable();
            $table->decimal('cemig_value_debit', 15, 2)->nullable()->comment('valor do credito ou debito');

            $table->text('iptu')->nullable();
            $table->string('iptu_type_debit', 5)->nullable()->comment('credito ou debito');
            $table->decimal('iptu_value_debit', 15, 2)->nullable()->comment('valor do credito ou debito');

            $table->text('garbage_rate')->nullable();
            $table->string('garbage_rate_type_debit', 5)->nullable()->comment('taxa de lixo credito ou debito');
            $table->decimal('garbage_rate_value_debit', 15, 2)->nullable()->comment('taxa de lixo valor do credito ou debito');

            $table->text('pendencies')->nullable();
            $table->string('pendencies_type_debit', 5)->nullable()->comment('credito ou debito');
            $table->decimal('pendencies_value_debit', 15, 2)->nullable()->comment('valor do credito ou debito');

            $table->text('paint')->nullable();
            $table->string('paint_type_debit', 5)->nullable()->comment('taxa de lixo credito ou debito');
            $table->decimal('paint_value_debit', 15, 2)->nullable()->comment('taxa de lixo valor do credito ou debito');

            $table->text('value_rent')->nullable();
            $table->string('value_rent_type_debit', 5)->nullable()->comment('credito ou debito');
            $table->decimal('value_rent_value_debit', 15, 2)->nullable()->comment('valor do credito ou debito');

            $table->integer('keys_delivery')->nullable()->comment('chaves entregues');
            $table->integer('control_gate')->nullable()->comment('controle de portão');
            $table->integer('control_alarm')->nullable()->comment('controle alarme');
            $table->integer('key_manual_gate')->nullable()->comment('chave manual do portão');
            $table->integer('fair_card')->nullable()->comment('cartão de feira');

            $table->string('new_address')->nullable();
            $table->string('new_neighborhood')->nullable();
            $table->string('new_city')->nullable();
            $table->string('new_state')->nullable();
            $table->string('new_zip_code')->nullable();

            $table->integer('termination_id');

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
        Schema::dropIfExists('termination_rent_accessories');
    }
}
