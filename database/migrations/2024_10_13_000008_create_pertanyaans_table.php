<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id();
            $table->string('documentId', 50)->unique();

            $table->text('pertanyaan');
            $table->text('jawaban');

            $table->string('kategori', 100)->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);

            $table->timestamps();

            $table->index(['aktif', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaans');
    }
};
