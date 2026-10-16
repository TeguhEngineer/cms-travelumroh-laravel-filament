<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use App\Models\Hotel;
use App\Models\Maskapai;
use App\Models\Pembimbing;
use App\Models\Perjalanan;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // --- Fasilitas (8): 3 umum, 3 umroh, 2 haji ---
        $fasilitas = [
            ['nama_fasilitas' => 'Antar-Jemput Bandara', 'kategori' => 'umum'],
            ['nama_fasilitas' => 'Makan 3x Sehari', 'kategori' => 'umum'],
            ['nama_fasilitas' => 'Asuransi Perjalanan', 'kategori' => 'umum'],
            ['nama_fasilitas' => 'Ziarah Madinah & Mekkah', 'kategori' => 'umroh'],
            ['nama_fasilitas' => 'Handling Dokumen & Visa Umroh', 'kategori' => 'umroh'],
            ['nama_fasilitas' => 'Koper & Perlengkapan Umroh', 'kategori' => 'umroh'],
            ['nama_fasilitas' => 'Bimbingan Manasik Haji Intensif', 'kategori' => 'haji'],
            ['nama_fasilitas' => 'Tenda Arafah & Mina Premium', 'kategori' => 'haji'],
        ];
        foreach ($fasilitas as $row) {
            Fasilitas::firstOrCreate(
                ['nama_fasilitas' => $row['nama_fasilitas']],
                ['kategori' => $row['kategori'], 'aktif' => true],
            );
        }

        // --- Maskapai (5) ---
        $maskapai = [
            ['nama_maskapai' => 'Garuda Indonesia', 'keterangan' => 'Maskapai nasional, penerbangan langsung Jakarta - Jeddah.'],
            ['nama_maskapai' => 'Saudi Arabian Airlines', 'keterangan' => 'Maskapai Arab Saudi, penerbangan langsung ke Jeddah & Madinah.'],
            ['nama_maskapai' => 'Emirates', 'keterangan' => 'Transit Dubai, bagasi 30kg + kabin 7kg.'],
            ['nama_maskapai' => 'Qatar Airways', 'keterangan' => 'Transit Doha, salah satu maskapai terbaik dunia.'],
            ['nama_maskapai' => 'Lion Air', 'keterangan' => 'Pilihan ekonomis dengan 1x transit.', 'aktif' => false],
        ];
        foreach ($maskapai as $row) {
            Maskapai::firstOrCreate(
                ['nama_maskapai' => $row['nama_maskapai']],
                ['keterangan' => $row['keterangan'], 'aktif' => $row['aktif'] ?? true],
            );
        }

        // --- Pembimbing (6): 3 tour-leader, 3 muthawwif ---
        $pembimbing = [
            ['nama_pembimbing' => 'Ust. Ahmad Hidayat', 'kategori' => 'tour-leader'],
            ['nama_pembimbing' => 'Ust. Budi Santoso', 'kategori' => 'tour-leader'],
            ['nama_pembimbing' => 'Ustzh. Siti Aminah', 'kategori' => 'tour-leader'],
            ['nama_pembimbing' => 'Syekh Abdullah Mahmud', 'kategori' => 'muthawwif'],
            ['nama_pembimbing' => 'Ust. Farhan Ali', 'kategori' => 'muthawwif'],
            ['nama_pembimbing' => 'Ust. Hamzah Yusuf', 'kategori' => 'muthawwif'],
        ];
        foreach ($pembimbing as $row) {
            Pembimbing::firstOrCreate(
                ['nama_pembimbing' => $row['nama_pembimbing']],
                ['kategori' => $row['kategori'], 'aktif' => true],
            );
        }

        // --- Perjalanan / destinasi ziarah (8) ---
        $perjalanan = [
            ['lokasi_perjalanan' => 'Mekkah – Masjidil Haram', 'deskripsi' => 'Ibadah umroh, thawaf, sai, dan sholat berjamaah di Masjidil Haram.'],
            ['lokasi_perjalanan' => 'Madinah – Masjid Nabawi', 'deskripsi' => 'Ziarah makam Rasulullah SAW dan sholat arbain di Masjid Nabawi.'],
            ['lokasi_perjalanan' => 'Jabal Uhud', 'deskripsi' => 'Ziarah ke bukit Uhud dan makam para syuhada perang Uhud.'],
            ['lokasi_perjalanan' => 'Masjid Quba', 'deskripsi' => 'Masjid pertama yang dibangun Rasulullah SAW, sholat 2 rakaat berpahala umroh.'],
            ['lokasi_perjalanan' => 'Jabal Rahmah & Arafah', 'deskripsi' => 'Ziarah ke padang Arafah tempat wukuf jamaah haji.'],
            ['lokasi_perjalanan' => 'Mina & Muzdalifah', 'deskripsi' => 'Mengenal lokasi mabit dan lempar jumrah saat prosesi haji.'],
            ['lokasi_perjalanan' => 'Thaif', 'deskripsi' => 'City tour kota Thaif: Masjid Ibnu Abbas, pabrik parfum, dan kebun buah.'],
            ['lokasi_perjalanan' => 'Istanbul – Blue Mosque', 'deskripsi' => 'City tour Istanbul: Blue Mosque, Hagia Sophia, dan Bosphorus Cruise (khusus paket plus).'],
        ];
        foreach ($perjalanan as $row) {
            Perjalanan::firstOrCreate(
                ['lokasi_perjalanan' => $row['lokasi_perjalanan']],
                ['deskripsi' => $row['deskripsi'], 'aktif' => true],
            );
        }

        // --- Hotel (6) ---
        $hotels = [
            ['nama_hotel' => 'Pullman ZamZam Makkah', 'lokasi' => 'Mekkah', 'rating' => 5, 'deskripsi_hotel' => 'Hotel bintang 5 tepat di depan Masjidil Haram, akses langsung ke area thawaf.'],
            ['nama_hotel' => 'Swissotel Al Maqam', 'lokasi' => 'Mekkah', 'rating' => 5, 'deskripsi_hotel' => 'Bagian dari Abraj Al Bait Tower, kamar luas dengan view Ka\'bah.'],
            ['nama_hotel' => 'Mövenpick Anwar Al Madinah', 'lokasi' => 'Madinah', 'rating' => 5, 'deskripsi_hotel' => 'Hotel bintang 5 di sisi utara Masjid Nabawi, favorit jamaah Indonesia.'],
            ['nama_hotel' => 'Dar Al Iman InterContinental', 'lokasi' => 'Madinah', 'rating' => 5, 'deskripsi_hotel' => 'Berada di pelataran Masjid Nabawi, cocok untuk jamaah lansia.'],
            ['nama_hotel' => 'Diyafa Hotel Makkah', 'lokasi' => 'Mekkah', 'rating' => 3, 'deskripsi_hotel' => 'Hotel ekonomis bersih ±800m dari Masjidil Haram dengan shuttle bus.'],
            ['nama_hotel' => 'Al Islam Hotel Madinah', 'lokasi' => 'Madinah', 'rating' => 3, 'deskripsi_hotel' => 'Hotel ekonomis ±400m dari Masjid Nabawi, cocok untuk paket hemat.'],
        ];
        foreach ($hotels as $row) {
            Hotel::firstOrCreate(
                ['nama_hotel' => $row['nama_hotel']],
                [
                    'lokasi' => $row['lokasi'],
                    'rating' => $row['rating'],
                    'deskripsi_hotel' => $row['deskripsi_hotel'],
                    'aktif' => true,
                ],
            );
        }

        $this->command->info('Master: 8 fasilitas, 5 maskapai, 6 pembimbing, 8 perjalanan, 6 hotel.');
    }
}
