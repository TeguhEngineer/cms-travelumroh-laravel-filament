<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('documentId', 50)->unique();
            $table->string('slug')->unique();

            $table->string('judul');
            $table->longText('konten');
            $table->text('excerpt')->nullable();
            $table->string('thumbnail')->nullable();

            $table->string('kategori', 100)->nullable();
            $table->json('tags')->nullable();

            $table->integer('views')->default(0);
            $table->boolean('aktif')->default(true)->index();

            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['aktif', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
