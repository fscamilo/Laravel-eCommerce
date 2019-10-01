<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('user_id');
			$table->string('reference')->unique();
			$table->bigInteger('driver_id')->nullable();
			$table->bigInteger('address_id');
			$table->enum('rating', [1, 2, 3, 4, 5])->nullable();
			$table->string('feedback')->nullable();
			$table->date('deliver_estimate')->nullable();
			$table->timestamp('delivered_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
