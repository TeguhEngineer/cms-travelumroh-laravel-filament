<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('pakets')->onDelete('cascade');

            $table->string('nama_fasilitas')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('icon', 50)->nullable();

            $table->timestamps();

            $table->index('paket_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_fasilitas');
    }
};
