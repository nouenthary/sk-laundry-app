<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('user_id')->nullable();
            $table->double('total')->nullable();
            $table->double('received_riel')->nullable();
            $table->double('received_dollar')->nullable();
            $table->double('total_riel')->nullable();
            $table->string('status')->nullable();
            $table->string('pay_by')->nullable();
            $table->string('print')->default('f');
            $table->string('tran_id')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('pay_status')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
