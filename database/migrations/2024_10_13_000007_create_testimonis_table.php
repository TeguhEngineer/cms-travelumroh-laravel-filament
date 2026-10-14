<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('documentId', 50)->unique();

            $table->string('nama');
            $table->string('foto')->nullable();
            $table->text('isi_testimoni');
            $table->integer('rating')->default(5);
            $table->string('paket_diikuti')->nullable();

            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);

            $table->timestamps();

            $table->index(['aktif', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
