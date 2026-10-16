<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("paket_details", function (Blueprint $table) {
            $table->id();
            $table->foreignId("paket_id")->constrained()->onDelete("cascade");

            // Foreign keys to master data (nullable - not all pakets use all)
            $table
                ->foreignId("fasilitas_id")
                ->nullable()
                ->constrained("fasilitas")
                ->onDelete("cascade");
            $table
                ->foreignId("hotel_id")
                ->nullable()
                ->constrained("hotels")
                ->onDelete("cascade");
            $table
                ->foreignId("maskapai_id")
                ->nullable()
                ->constrained("maskapais")
                ->onDelete("cascade");
            $table
                ->foreignId("pembimbing_id")
                ->nullable()
                ->constrained("pembimbings")
                ->onDelete("cascade");
            $table
                ->foreignId("perjalanan_id")
                ->nullable()
                ->constrained("perjalanans")
                ->onDelete("cascade");

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("paket_details");
    }
};
