<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceAndTransactionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->bigInteger('transaction_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('invoice_number');
        });
    }
}
