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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('position_id');
            $table->integer('department_id');
            $table->text('address')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('experience')->nullable();
            $table->string('photo')->nullable();
            $table->integer('salary')->nullable();
            // $table->string('vacation')->nullable();
            // $table->string('city')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
