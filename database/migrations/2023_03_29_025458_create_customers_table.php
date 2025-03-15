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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('NamaLembaga');
            $table->text('AlamatLembaga')->nullable();
            $table->string('TelpLembaga')->nullable();
            $table->string('EmailLembaga')->nullable();
            $table->string('Potensi')->nullable();
            $table->string('CatatanLembaga')->nullable();
            $table->string('NamaCustomer');
            $table->string('Jabatan')->nullable();
            $table->text('AlamatCustomer')->nullable();
            $table->string('TelpCustomer')->nullable();
            $table->string('EmailCustomer')->nullable();
            $table->string('CatatanCustomer')->nullable();
            $table->string('FotoCustomer')->nullable();
            $table->string('FotoKTP')->nullable();
            $table->integer('employee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
