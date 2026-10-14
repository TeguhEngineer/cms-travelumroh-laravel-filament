<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('documentId', 50)->unique();

            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('url_foto');
            $table->string('lokasi', 100)->nullable();

            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);

            $table->timestamps();

            $table->index('lokasi');
            $table->index(['aktif', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
