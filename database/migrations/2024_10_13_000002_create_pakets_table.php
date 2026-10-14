<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('documentId', 50)->unique();
            $table->string('slug')->unique();

            // Basic Info
            $table->string('name')->index();
            $table->enum('type', ['umrah', 'haji'])->index();
            $table->longText('description')->nullable();

            // Pricing
            $table->decimal('price', 15, 2);
            $table->decimal('discount_price', 15, 2)->nullable();

            // Schedule
            $table->date('tanggal_berangkat')->nullable();
            $table->date('tanggal_pulang')->nullable();
            $table->integer('durasi_hari')->default(0);

            // Capacity
            $table->integer('quota_seat')->default(0);
            $table->integer('sisa_seat')->default(0);

            // Details
            $table->string('kota_keberangkatan', 100)->nullable();
            $table->integer('hotel_rating')->default(3);
            $table->string('thumbnail')->nullable();

            // Features
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_promo')->default(false);
            $table->boolean('aktif')->default(true)->index();
            $table->integer('urutan')->default(0);

            // Timestamps
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Composite indexes
            $table->index(['type', 'aktif']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
