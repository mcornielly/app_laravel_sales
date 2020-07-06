<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('product_id');
            $table->decimal('price', 11, 2);
            $table->decimal('margin_gain_u', 4, 2);
            $table->decimal('price_gain_u', 11, 2);
            $table->decimal('unit_divisa', 11, 2);
            $table->decimal('unit_price', 11, 2);
            $table->decimal('margin_gain_w', 4, 2);
            $table->decimal('price_gain_w', 11, 2);
            $table->decimal('wholesale_divisa', 11, 2);
            $table->decimal('wholesale_price', 11, 2);
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
        Schema::dropIfExists('product_histories');
    }
}
