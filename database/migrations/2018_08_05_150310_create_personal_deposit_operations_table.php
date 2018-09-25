<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalDepositOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_deposit_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('asset_id');
            $table->decimal('value', 24, 8);
            $table->string('transaction_id')->default('');
            $table->boolean('is_escrow_operation')->default(false);
            $table->decimal('balance', 24, 8);
            $table->decimal('blockchain_balance', 24, 8);
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
        Schema::dropIfExists('personal_deposit_operations');
    }
}
