<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use App\Models\Hotel;
use App\Models\Maskapai;
use App\Models\Paket;
use App\Models\Pembimbing;
use App\Models\Perjalanan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil master yang sudah di-seed
        $fasUmum = Fasilitas::where('kategori', 'umum')->pluck('id')->all();
        $fasUmroh = Fasilitas::where('kategori', 'umroh')->pluck('id')->all();
        $fasHaji = Fasilitas::where('kategori', 'haji')->pluck('id')->all();
        $garuda = Maskapai::where('nama_maskapai', 'Garuda Indonesia')->first();
        $saudia = Maskapai::where('nama_maskapai', 'Saudi Arabian Airlines')->first();
        $qatar = Maskapai::where('nama_maskapai', 'Qatar Airways')->first();
        $tourLeaders = Pembimbing::where('kategori', 'tour-leader')->pluck('id')->all();
        $muthawwifs = Pembimbing::where('kategori', 'muthawwif')->pluck('id')->all();
        $mekkah = Perjalanan::where('lokasi_perjalanan', 'like', 'Mekkah%')->first();
        $madinah = Perjalanan::where('lokasi_perjalanan', 'like', 'Madinah%')->first();
        $uhud = Perjalanan::where('lokasi_perjalanan', 'like', 'Jabal Uhud%')->first();
        $quba = Perjalanan::where('lokasi_perjalanan', 'like', 'Masjid Quba%')->first();
        $thaif = Perjalanan::where('lokasi_perjalanan', 'like', 'Thaif%')->first();
        $arafah = Perjalanan::where('lokasi_perjalanan', 'like', 'Jabal Rahmah%')->first();
        $mina = Perjalanan::where('lokasi_perjalanan', 'like', 'Mina%')->first();
        $hotelMekkah5 = Hotel::where('lokasi', 'Mekkah')->where('rating', 5)->first();
        $hotelMadinah5 = Hotel::where('lokasi', 'Madinah')->where('rating', 5)->first();
        $hotelMekkah3 = Hotel::where('lokasi', 'Mekkah')->where('rating', 3)->first();
        $hotelMadinah3 = Hotel::where('lokasi', 'Madinah')->where('rating', 3)->first();

        $now = Carbon::now();

        $pakets = [
            [
                'name' => 'Umroh Reguler 9 Hari',
                'type' => 'umrah',
                'description' => '<p>Paket umroh 9 hari favorit dengan penerbangan langsung, hotel bintang 5 dekat Masjidil Haram & Nabawi.</p>',
                'price' => 32500000,
                'discount_percent' => 10,
                'tanggal_berangkat' => $now->copy()->addMonths(2)->toDateString(),
                'durasi_hari' => 9,
                'quota_seat' => 45,
                'sisa_seat' => 12,
                'kota_keberangkatan' => 'Jakarta',
                'hotel_rating' => 5,
                'is_featured' => true,
                'is_promo' => true,
                'fasilitas_ids' => array_merge($fasUmum, array_slice($fasUmroh, 0, 2)),
            ],
            [
                'name' => 'Umroh Plus Turki 12 Hari',
                'type' => 'umrah',
                'description' => '<p>Umroh 9 hari + 3 hari city tour Istanbul: Blue Mosque, Hagia Sophia, dan Bosphorus Cruise.</p>',
                'price' => 45900000,
                'discount_percent' => null,
                'tanggal_berangkat' => $now->copy()->addMonths(3)->toDateString(),
                'durasi_hari' => 12,
                'quota_seat' => 40,
                'sisa_seat' => 25,
                'kota_keberangkatan' => 'Jakarta',
                'hotel_rating' => 5,
                'is_featured' => true,
                'is_promo' => false,
                'fasilitas_ids' => array_merge($fasUmum, $fasUmroh),
            ],
            [
                'name' => 'Umroh Hemat 9 Hari',
                'type' => 'umrah',
                'description' => '<p>Pilihan ekonomis dengan hotel bintang 3 bersih dan 1x transit. Ibadah tetap maksimal.</p>',
                'price' => 26900000,
                'discount_percent' => 5,
                'tanggal_berangkat' => $now->copy()->addMonths(2)->addWeeks(2)->toDateString(),
                'durasi_hari' => 9,
                'quota_seat' => 45,
                'sisa_seat' => 30,
                'kota_keberangkatan' => 'Surabaya',
                'hotel_rating' => 3,
                'is_featured' => false,
                'is_promo' => true,
                'hemat' => true,
                'fasilitas_ids' => array_merge(array_slice($fasUmum, 0, 2), array_slice($fasUmroh, 0, 1)),
            ],
            [
                'name' => 'Umroh Ramadhan 14 Hari',
                'type' => 'umrah',
                'description' => '<p>Raih kemuliaan umroh di bulan Ramadhan: Lailatul Qadar, buka puasa bersama, dan i\'tikaf di Masjidil Haram.</p>',
                'price' => 39500000,
                'discount_percent' => null,
                'tanggal_berangkat' => $now->copy()->addMonths(5)->toDateString(),
                'durasi_hari' => 14,
                'quota_seat' => 45,
                'sisa_seat' => 45,
                'kota_keberangkatan' => 'Jakarta',
                'hotel_rating' => 5,
                'is_featured' => false,
                'is_promo' => false,
                'fasilitas_ids' => array_merge($fasUmum, $fasUmroh),
            ],
            [
                'name' => 'Haji Khusus ONH Plus 25 Hari',
                'type' => 'haji',
                'description' => '<p>Haji khusus dengan masa tunggu lebih singkat, tenda premium di Arafah & Mina, hotel bintang 5.</p>',
                'price' => 285000000,
                'discount_percent' => null,
                'tanggal_berangkat' => $now->copy()->addMonths(8)->toDateString(),
                'durasi_hari' => 25,
                'quota_seat' => 45,
                'sisa_seat' => 20,
                'kota_keberangkatan' => 'Jakarta',
                'hotel_rating' => 5,
                'is_featured' => true,
                'is_promo' => false,
                'fasilitas_ids' => array_merge($fasUmum, $fasHaji),
            ],
            [
                'name' => 'Haji Furoda Tanpa Antri',
                'type' => 'haji',
                'description' => '<p>Berangkat haji tahun ini juga dengan visa furoda resmi. Kuota sangat terbatas.</p>',
                'price' => 390000000,
                'discount_percent' => null,
                'tanggal_berangkat' => $now->copy()->addMonths(8)->addWeeks(1)->toDateString(),
                'durasi_hari' => 21,
                'quota_seat' => 20,
                'sisa_seat' => 6,
                'kota_keberangkatan' => 'Jakarta',
                'hotel_rating' => 5,
                'is_featured' => true,
                'is_promo' => false,
                'fasilitas_ids' => array_merge($fasUmum, $fasHaji),
            ],
        ];

        foreach ($pakets as $row) {
            $berangkat = Carbon::parse($row['tanggal_berangkat']);
            $pulang = $berangkat->copy()->addDays($row['durasi_hari'] - 1);
            $percent = $row['discount_percent'];
            $discountPrice = $percent ? round($row['price'] * (1 - $percent / 100)) : null;

            $paket = Paket::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($row['name'])],
                [
                    'name' => $row['name'],
                    'type' => $row['type'],
                    'description' => $row['description'],
                    'price' => $row['price'],
                    'discount_percent' => $percent,
                    'discount_price' => $discountPrice,
                    'tanggal_berangkat' => $berangkat->toDateString(),
                    'tanggal_pulang' => $pulang->toDateString(),
                    'durasi_hari' => $row['durasi_hari'],
                    'quota_seat' => $row['quota_seat'],
                    'sisa_seat' => $row['sisa_seat'],
                    'kota_keberangkatan' => $row['kota_keberangkatan'],
                    'hotel_rating' => $row['hotel_rating'],
                    'is_featured' => $row['is_featured'],
                    'is_promo' => $row['is_promo'],
                    'aktif' => true,
                    'published_at' => $now,
                ],
            );

            // Detail hanya diisi sekali (lewati bila paket sudah punya detail)
            $isHemat = $row['hemat'] ?? false;
            $hotelMekkah = $isHemat ? $hotelMekkah3 : $hotelMekkah5;
            $hotelMadinah = $isHemat ? $hotelMadinah3 : $hotelMadinah5;
            $maskapaiPergi = $isHemat ? $qatar : $garuda;
            $maskapaiPulang = $isHemat ? $qatar : $saudia;

            if ($paket->fasilitasDetails()->count() === 0 && ! empty($row['fasilitas_ids'])) {
                $paket->fasilitas()->syncWithoutDetaching($row['fasilitas_ids']);
            }

            if ($paket->hotelDetails()->count() === 0 && $hotelMekkah && $hotelMadinah) {
                $paket->hotelDetails()->createMany([
                    ['hotel_id' => $hotelMekkah->id, 'checkin' => $berangkat->toDateString(), 'checkout' => $berangkat->copy()->addDays(4)->toDateString()],
                    ['hotel_id' => $hotelMadinah->id, 'checkin' => $berangkat->copy()->addDays(4)->toDateString(), 'checkout' => $pulang->toDateString()],
                ]);
            }

            if ($paket->maskapaiDetails()->count() === 0 && $maskapaiPergi && $maskapaiPulang) {
                $paket->maskapaiDetails()->createMany([
                    [
                        'maskapai_id' => $maskapaiPergi->id,
                        'nomor_penerbangan' => 'GA-982',
                        'bandara_keberangkatan' => 'CGK - Soekarno Hatta',
                        'bandara_tujuan' => 'JED - King Abdulaziz',
                        'waktu_berangkat' => $berangkat->copy()->setTime(8, 0),
                        'waktu_tiba' => $berangkat->copy()->setTime(14, 30),
                        'tipe_penerbangan' => 'keberangkatan',
                    ],
                    [
                        'maskapai_id' => $maskapaiPulang->id,
                        'nomor_penerbangan' => 'SV-823',
                        'bandara_keberangkatan' => 'MED - Prince Mohammad',
                        'bandara_tujuan' => 'CGK - Soekarno Hatta',
                        'waktu_berangkat' => $pulang->copy()->setTime(10, 0),
                        'waktu_tiba' => $pulang->copy()->setTime(23, 45),
                        'tipe_penerbangan' => 'kepulangan',
                    ],
                ]);
            }

            if ($paket->pembimbingDetails()->count() === 0 && $tourLeaders && $muthawwifs) {
                $paket->pembimbingDetails()->createMany([
                    ['pembimbing_id' => $tourLeaders[0]],
                    ['pembimbing_id' => $muthawwifs[0]],
                ]);
            }

            $destinasi = $row['type'] === 'haji'
                ? [$arafah, $mina, $mekkah, $madinah]
                : [$mekkah, $madinah, $uhud, $quba, $thaif];

            if ($paket->perjalananDetails()->count() === 0) {
                $day = 1;
                foreach ($destinasi as $dest) {
                    if (! $dest) {
                        continue;
                    }
                    $paket->perjalananDetails()->create([
                        'perjalanan_id' => $dest->id,
                        'tanggal' => $berangkat->copy()->addDays($day)->toDateString(),
                    ]);
                    $day += 2;
                }
            }
        }

        $this->command->info('Paket: 4 umroh + 2 haji beserta detail.');
    }
}
