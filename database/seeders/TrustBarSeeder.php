<?php

namespace Database\Seeders;

use App\Models\TrustBar;
use Illuminate\Database\Seeder;

class TrustBarSeeder extends Seeder
{
    public function run(): void
    {
        // Jangan timpa data yang sudah diisi lewat CMS
        if (TrustBar::query()->exists()) {
            $this->command->info('Trust Bar: sudah ada, dilewati.');

            return;
        }

        $items = [
            [
                'judul' => 'SK Kemenag RI',
                'deskripsi' => 'No. D/123/2020',
                'ikon' => 'shield',
                'urutan' => 1,
            ],
            [
                'judul' => 'Sertifikasi PPIU',
                'deskripsi' => 'Resmi & Terpercaya',
                'ikon' => 'award',
                'urutan' => 2,
            ],
            [
                'judul' => 'Member ASPHURI',
                'deskripsi' => 'Asosiasi Travel Haji Umrah',
                'ikon' => 'building',
                'urutan' => 3,
            ],
            [
                'judul' => '50.000+ Jamaah',
                'deskripsi' => 'Telah Berangkat',
                'ikon' => 'users',
                'urutan' => 4,
            ],
        ];

        foreach ($items as $item) {
            TrustBar::create($item);
        }

        $this->command->info('Trust Bar: ' . count($items) . ' baris dibuat.');
    }
}
