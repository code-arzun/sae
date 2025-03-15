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
        Schema::create('writers', function (Blueprint $table) {
            $table->id();
            $table->string('NamaPenulis');
            $table->text('AlamatPenulis')->nullable();
            $table->string('TelpPenulis')->nullable();
            $table->string('EmailPenulis')->nullable();
            $table->string('CatatanPenulis')->nullable();
            $table->integer('writerjob_id')->nullable();
            $table->string('writercategory_id')->nullable();
            $table->string('FotoPenulis')->nullable();
            $table->string('FotoKTP')->nullable();
            $table->string('NIK')->nullable();
            $table->string('NPWP')->nullable();
            $table->integer('employee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writers');
    }
};
