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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('date');
            $table->string('status');
            // $table->string('description')->nullable();
            // $table->time('arrival')->nullable();
            // $table->time('leave')->nullable();
            // $table->string('journal')->nullable();
            $table->string('keterangan')->nullable();
            // $table->time('datang')->nullable();
            // $table->time('pulang')->nullable();
            $table->time('datang')->format('H:i:s')->nullable();
            $table->time('pulang')->format('H:i:s')->nullable();
            $table->string('jurnal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
