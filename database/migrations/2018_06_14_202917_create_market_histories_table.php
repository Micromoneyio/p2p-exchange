<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('currency_id');
            $table->unsignedInteger('unit_currency_id');
            $table->unsignedInteger('rate_source_id');
            $table->float('market_cap',30);
            $table->float('price');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('unit_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('rate_source_id')->references('id')->on('rate_sources')->onDelete('cascade');
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
        Schema::dropIfExists('market_histories');
    }
}
