<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Jangan timpa data asli bila sudah diisi lewat halaman Pengaturan
        if (Setting::query()->exists()) {
            $this->command->info('Setting: sudah ada, dilewati.');

            return;
        }

        Setting::create([
            'company_name' => 'Asella Wisata',
            'company_description' => 'Biro perjalanan haji & umroh terpercaya dengan izin resmi Kemenag.',
            'nomor_sk_umroh' => 'SK-UMROH-2024-001',
            'nomor_sk_haji' => 'SK-HAJI-2024-001',
            'telepon_1' => '0211234567',
            'email' => 'info@asellawisata.com',
            'alamat' => 'Jl. Contoh Raya No. 123, Jakarta Selatan',
            'detail_alamat' => 'Gedung Asella Lt. 2, dekat Stasiun Contoh',
            'whatsapp' => '6281234567890',
            'facebook' => 'https://facebook.com/asellawisata',
            'instagram' => 'https://instagram.com/asellawisata',
            'youtube' => 'https://youtube.com/@asellawisata',
            'tiktok' => 'https://tiktok.com/@asellawisata',
            'seo_title' => 'Asella Wisata - Travel Haji & Umroh Terpercaya',
            'seo_description' => 'Wujudkan perjalanan ibadah haji dan umroh yang aman, nyaman, dan berkesan bersama Asella Wisata.',
            'seo_keywords' => 'umroh, haji, travel umroh, paket umroh, paket haji',
            'cover_title' => 'Wujudkan Perjalanan Ibadah Impian Anda',
            'cover_subtitle' => 'Berangkat haji & umroh dengan bimbingan sesuai sunnah, fasilitas nyaman, dan harga transparan.',
            'deskripsi_perusahaan' => '<p><strong>Asella Wisata</strong> adalah biro perjalanan haji dan umroh yang berkomitmen memberikan pelayanan terbaik bagi para tamu Allah.</p>',
            'visi' => 'Menjadi biro perjalanan haji & umroh paling dipercaya di Indonesia.',
            'misi' => "1. Memberikan pelayanan prima sesuai sunnah.\n2. Menjamin kenyamanan dan keamanan jamaah.\n3. Harga transparan tanpa biaya tersembunyi.",
        ]);

        $this->command->info('Setting: 1 baris dibuat.');
    }
}
