<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_invoice_details', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');

            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services');

            $table->integer('qty');
            $table->double('weight');
            $table->double('price');
            $table->double('discount');
            $table->double('total');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('status')->nullable();

            $table->string('pay_type')->nullable();

            $table->unsignedInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('agents');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->double('percent_commission')->nullable();
            $table->double('commission')->nullable();

            $table->unsignedInteger('agent_invoice_id')->nullable();
            $table->foreign('agent_invoice_id')->references('id')->on('agent_invoices')->nullable();

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
        Schema::dropIfExists('agent_invoice_details');
    }
}
