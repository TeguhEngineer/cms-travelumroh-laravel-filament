<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_pembimbing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained()->onDelete('cascade');
            $table->foreignId('pembimbing_id')->constrained('pembimbings')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['paket_id', 'pembimbing_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_pembimbing_details');
    }
};
