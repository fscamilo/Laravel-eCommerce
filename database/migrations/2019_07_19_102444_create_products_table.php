<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->char('sku', 7);
            $table->string('name');
            $table->longText('description')->nullable();
			$table->float('price', 7, 2);
			$table->bigInteger('category_id');
			$table->char('image')->nullable();
			$table->boolean('force_popular');
			$table->boolean('force_new');
			$table->boolean('force_sale');
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
