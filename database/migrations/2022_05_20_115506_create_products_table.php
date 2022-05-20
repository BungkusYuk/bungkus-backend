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
            $table->id();
            $table->bigInteger('transactions_id')->constrained('transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('label');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('size');
            $table->string('detail');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
