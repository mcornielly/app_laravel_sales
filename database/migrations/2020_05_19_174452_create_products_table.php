<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url')->nullable();
            $table->unsignedInteger('category_id');
            $table->string('code')->nullable();
            $table->decimal('price', 11, 2)->nullable();
            $table->mediumText('description')->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('margin_gain_u', 4, 2)->nullable();
            $table->decimal('divisa_unit', 11, 2)->nullable();
            $table->integer('wholesale_quantity')->nullable();
            $table->decimal('margin_gain_w', 4, 2)->nullable();
            $table->decimal('wholesale_divisa', 11, 2)->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes(); //Nueva línea, para el borrado lógico
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
        Schema::dropIfExists('products');
    }
}
