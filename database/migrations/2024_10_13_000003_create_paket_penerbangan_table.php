<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_penerbangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('pakets')->onDelete('cascade');

            $table->string('nomor_penerbangan', 50)->nullable();
            $table->string('nama_maskapai', 100)->nullable();
            $table->string('bandara_keberangkatan', 100)->nullable();
            $table->string('bandara_tujuan', 100)->nullable();
            $table->dateTime('tanggal_keberangkatan')->nullable();
            $table->dateTime('tanggal_tiba')->nullable();

            $table->timestamps();

            $table->index('paket_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_penerbangan');
    }
};
