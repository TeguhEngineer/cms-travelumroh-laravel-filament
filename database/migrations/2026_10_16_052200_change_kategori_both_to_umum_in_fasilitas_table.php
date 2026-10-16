<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Step 1: Add 'umum' to enum (keep 'both' temporarily)
        DB::statement(
            "ALTER TABLE fasilitas MODIFY kategori ENUM('umroh', 'haji', 'both', 'umum') DEFAULT 'both'",
        );

        // Step 2: Update existing 'both' values to 'umum'
        DB::table("fasilitas")
            ->where("kategori", "both")
            ->update(["kategori" => "umum"]);

        // Step 3: Remove 'both' from enum
        DB::statement(
            "ALTER TABLE fasilitas MODIFY kategori ENUM('umroh', 'haji', 'umum') DEFAULT 'umum'",
        );
    }

    public function down(): void
    {
        // Revert back
        DB::table("fasilitas")
            ->where("kategori", "umum")
            ->update(["kategori" => "both"]);

        DB::statement(
            "ALTER TABLE fasilitas MODIFY kategori ENUM('umroh', 'haji', 'both') DEFAULT 'both'",
        );
    }
};
