<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Company Info
            $table->string('company_name')->nullable();
            $table->text('company_description')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('nomor_sk_umroh', 100)->nullable();
            $table->string('nomor_sk_haji', 100)->nullable();

            // Contact
            $table->string('telepon_1', 20)->nullable();
            $table->string('telepon_2', 20)->nullable();
            $table->string('telepon_3', 20)->nullable();
            $table->string('telepon_4', 20)->nullable();
            $table->string('telepon_5', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->text('detail_alamat')->nullable();

            // Social Media
            $table->string('whatsapp', 20)->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();

            // Hero Cover
            $table->string('cover_image')->nullable();
            $table->string('cover_title')->nullable();
            $table->text('cover_subtitle')->nullable();

            // Tentang Kami
            $table->longText('deskripsi_perusahaan')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
