<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_maskapai_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained()->onDelete('cascade');
            $table->foreignId('maskapai_id')->constrained('maskapais')->onDelete('cascade');
            $table->string('nomor_penerbangan', 50)->nullable();
            $table->string('bandara_keberangkatan', 100)->nullable();
            $table->string('bandara_tujuan', 100)->nullable();
            $table->dateTime('waktu_berangkat')->nullable();
            $table->dateTime('waktu_tiba')->nullable();
            $table->enum('tipe_penerbangan', ['keberangkatan', 'kepulangan'])->default('keberangkatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_maskapai_details');
    }
};
