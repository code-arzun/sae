<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('paid_by');
            $table->string('payment_method');
            $table->integer('employee_id')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('no_rek')->nullable();
            $table->integer('rekening_id')->nullable();
            $table->integer('pay');
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->integer('discount_rp')->nullable();
            $table->decimal('PPN_percent', 5, 2)->nullable();
            $table->integer('PPN_rp')->nullable();
            $table->integer('admin_fee')->nullable();
            $table->integer('other_fee')->nullable();
            $table->integer('grandtotal');
            $table->integer('due');
            $table->string('payment_status');
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
