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
        Schema::create('cashflows', function (Blueprint $table) {
            $table->id();
            $table->integer('cashflowcategory_id');
            $table->integer('department_id');
            $table->string('cashflow_code')->nullable();
            $table->integer('nominal');
            $table->string('notes');
            $table->date('date');
            $table->string('method')->nullable();
            $table->integer('rekening_id')->nullable();
            $table->string('receipt')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashflows');
    }
};
