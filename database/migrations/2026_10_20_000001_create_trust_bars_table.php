<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trust_bars', function (Blueprint $table) {
            $table->id();
            $table->string('documentId', 50)->unique();

            $table->string('judul', 255);
            $table->string('deskripsi', 255)->nullable();
            $table->string('ikon', 50)->nullable();

            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);

            $table->timestamps();

            $table->index(['aktif', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trust_bars');
    }
};
