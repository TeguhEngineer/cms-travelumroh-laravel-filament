<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\Gallery;
use App\Models\Pertanyaan;
use App\Models\Testimoni;
use App\Models\VideoYoutube;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KontenSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // --- Artikel (6) ---
        $artikels = [
            [
                'judul' => 'Panduan Lengkap Persiapan Umroh Pertama Kali',
                'kategori' => 'Panduan',
                'tags' => ['umroh', 'persiapan', 'pemula'],
                'excerpt' => 'Dokumen, vaksin, perlengkapan, dan manasik — semua yang perlu disiapkan sebelum berangkat umroh.',
                'konten' => '<p>Menunaikan umroh pertama kali bisa terasa menegangkan. Mulailah dengan memastikan paspor aktif minimal 7 bulan, melengkapi vaksinasi meningitis, mengikuti manasik, dan menyiapkan perlengkapan ihram serta obat-obatan pribadi.</p>',
            ],
            [
                'judul' => 'Perbedaan Haji Reguler, Haji Khusus, dan Haji Furoda',
                'kategori' => 'Haji',
                'tags' => ['haji', 'reguler', 'khusus', 'furoda'],
                'excerpt' => 'Kenali perbedaan masa tunggu, fasilitas, dan biaya ketiga jenis program haji resmi.',
                'konten' => '<p>Haji reguler dikelola pemerintah dengan masa tunggu belasan hingga puluhan tahun. Haji khusus (ONH Plus) dikelola travel resmi dengan masa tunggu 5-7 tahun, sedangkan haji furoda menggunakan visa resmi undangan dan bisa berangkat di tahun yang sama.</p>',
            ],
            [
                'judul' => '7 Adab Ziarah ke Masjid Nabawi yang Perlu Diketahui',
                'kategori' => 'Panduan',
                'tags' => ['madinah', 'ziarah', 'adab'],
                'excerpt' => 'Tata cara dan adab berziarah ke makam Rasulullah SAW serta Raudhah.',
                'konten' => '<p>Saat berziarah ke Masjid Nabawi, jagalah kesucian, berpakaian rapi, menjaga suara, dan mengikuti arahan muthawwif terutama saat antre masuk Raudhah.</p>',
            ],
            [
                'judul' => 'Tips Umroh Bersama Lansia agar Tetap Nyaman',
                'kategori' => 'Tips',
                'tags' => ['umroh', 'lansia', 'tips'],
                'excerpt' => 'Pilih hotel dekat masjid, siapkan kursi roda, dan atur ritme ibadah yang tidak memaksakan.',
                'konten' => '<p>Umroh bersama orang tua lansia membutuhkan persiapan ekstra: hotel sedekat mungkin dengan masjid, kursi roda lipat, obat rutin, serta jadwal ibadah yang fleksibel dengan banyak istirahat.</p>',
            ],
            [
                'judul' => 'Jadwal Keberangkatan Umroh 2026 Telah Dibuka',
                'kategori' => 'Info',
                'tags' => ['jadwal', 'umroh', '2026'],
                'excerpt' => 'Amankan seat lebih awal untuk keberangkatan favorit dan dapatkan harga early bird.',
                'konten' => '<p>Jadwal keberangkatan umroh 2026 sudah tersedia. Pemesanan lebih awal memberi keleluasaan memilih tanggal, maskapai, dan hotel sesuai kebutuhan keluarga Anda.</p>',
            ],
            [
                'judul' => 'Keutamaan Umroh di Bulan Ramadhan',
                'kategori' => 'Keutamaan',
                'tags' => ['ramadhan', 'umroh', 'keutamaan'],
                'excerpt' => 'Umroh di bulan Ramadhan pahalanya setara dengan haji bersama Rasulullah SAW.',
                'konten' => '<p>Rasulullah SAW bersabda bahwa umroh di bulan Ramadhan setara dengan haji bersamaku (HR. Bukhari & Muslim). Manfaatkan momen penuh berkah ini dengan persiapan fisik dan spiritual yang matang.</p>',
            ],
        ];
        foreach ($artikels as $i => $row) {
            Artikel::firstOrCreate(
                ['judul' => $row['judul']],
                [
                    'konten' => $row['konten'],
                    'excerpt' => $row['excerpt'],
                    'kategori' => $row['kategori'],
                    'tags' => $row['tags'],
                    'views' => ($i + 1) * 137,
                    'aktif' => true,
                    'published_at' => $now->copy()->subDays($i * 4),
                ],
            );
        }

        // --- Galeri (6) ---
        $galleries = [
            ['judul' => 'Thawaf di Masjidil Haram', 'lokasi' => 'Mekkah'],
            ['judul' => 'Sholat Berjamaah di Masjid Nabawi', 'lokasi' => 'Madinah'],
            ['judul' => 'Ziarah Jabal Uhud', 'lokasi' => 'Madinah'],
            ['judul' => 'City Tour Thaif', 'lokasi' => 'Thaif'],
            ['judul' => 'Mabit di Mina', 'lokasi' => 'Mina'],
            ['judul' => 'Kebersamaan Jamaah Asella', 'lokasi' => 'Mekkah'],
        ];
        foreach ($galleries as $i => $row) {
            Gallery::firstOrCreate(
                ['judul' => $row['judul']],
                [
                    'deskripsi' => 'Dokumentasi perjalanan jamaah Asella Wisata — '.$row['judul'].'.',
                    'url_foto' => 'https://picsum.photos/seed/asella-galeri-'.($i + 1).'/1200/800',
                    'lokasi' => $row['lokasi'],
                    'aktif' => true,
                ],
            );
        }

        // --- Testimoni (6) ---
        $testimonis = [
            ['nama' => 'H. Muhammad Ridwan', 'rating' => 5, 'paket_diikuti' => 'Umroh Reguler 9 Hari', 'isi_testimoni' => 'Alhamdulillah pelayanan sangat memuaskan. Pembimbing sabar, hotel dekat, dan jadwal ziarah tertata rapi.'],
            ['nama' => 'Hjh. Nurhaliza', 'rating' => 5, 'paket_diikuti' => 'Umroh Plus Turki 12 Hari', 'isi_testimoni' => 'Pengalaman luar biasa, dari Mekkah-Madinah sampai Istanbul semuanya terorganisir. Makanan cocok untuk lidah Indonesia.'],
            ['nama' => 'Drs. H. Supriyanto', 'rating' => 5, 'paket_diikuti' => 'Haji Khusus ONH Plus 25 Hari', 'isi_testimoni' => 'Tenda di Arafah nyaman, muthawwif siaga 24 jam. Ibadah haji kami berjalan lancar dan khusyuk.'],
            ['nama' => 'Hjh. Ratna Dewi', 'rating' => 4, 'paket_diikuti' => 'Umroh Hemat 9 Hari', 'isi_testimoni' => 'Paket hemat tapi tidak murahan. Hotel bersih, transport nyaman. Semoga bisa berangkat lagi bersama keluarga.'],
            ['nama' => 'H. Abdul Karim', 'rating' => 5, 'paket_diikuti' => 'Umroh Ramadhan 14 Hari', 'isi_testimoni' => 'Bisa i\'tikaf di Masjidil Haram saat 10 malam terakhir adalah pengalaman tak terlupakan. Terima kasih Asella.'],
            ['nama' => 'Hjh. Fatimah Zahra', 'rating' => 5, 'paket_diikuti' => 'Umroh Reguler 9 Hari', 'isi_testimoni' => 'Berangkat bersama ibu yang sudah sepuh, dibantu kursi roda dan pendampingan khusus. Sangat terbantu dan terharu.'],
        ];
        foreach ($testimonis as $row) {
            Testimoni::firstOrCreate(
                ['nama' => $row['nama'], 'paket_diikuti' => $row['paket_diikuti']],
                [
                    'isi_testimoni' => $row['isi_testimoni'],
                    'rating' => $row['rating'],
                    'aktif' => true,
                ],
            );
        }

        // --- FAQ (6) ---
        $faqs = [
            ['pertanyaan' => 'Apa saja syarat dokumen untuk mendaftar umroh?', 'jawaban' => 'KTP, KK, paspor aktif minimal 7 bulan, buku nikah (bagi pasangan), serta pas foto. Tim kami membantu pengurusan visa dan Siskopatuh.', 'kategori' => 'Umroh'],
            ['pertanyaan' => 'Berapa lama masa tunggu haji khusus (ONH Plus)?', 'jawaban' => 'Estimasi masa tunggu haji khusus saat ini sekitar 5-7 tahun tergantung kuota provinsi. Sedangkan haji furoda bisa berangkat di tahun yang sama selama kuota visa tersedia.', 'kategori' => 'Haji'],
            ['pertanyaan' => 'Apakah harga paket sudah termasuk tiket pesawat dan visa?', 'jawaban' => 'Ya, harga yang tertera sudah termasuk tiket pesawat PP, visa, hotel, makan 3x sehari, transport, muthawwif, handling, dan asuransi perjalanan. Tidak ada biaya tersembunyi.', 'kategori' => 'Umroh'],
            ['pertanyaan' => 'Bagaimana kebijakan pembatalan dan refund?', 'jawaban' => 'Pembatalan H-45 mendapat refund 75%, H-30 sebesar 50%, dan H-14 sebesar 25% dari total biaya, di luar biaya visa dan tiket yang sudah diterbitkan.', 'kategori' => 'Umum'],
            ['pertanyaan' => 'Apakah tersedia pendampingan untuk jamaah lansia?', 'jawaban' => 'Tersedia. Kami menyiapkan kursi roda, hotel dekat masjid, serta pendamping khusus dengan biaya tambahan yang transparan.', 'kategori' => 'Umum'],
            ['pertanyaan' => 'Kapan waktu terbaik mengambil foto di Raudhah?', 'jawaban' => 'Jadwal kunjungan Raudhah diatur melalui aplikasi Nusuk. Muthawwif kami akan mendampingi dan mengatur antrean agar seluruh jamaah mendapat kesempatan.', 'kategori' => 'Madinah'],
        ];
        foreach ($faqs as $row) {
            Pertanyaan::firstOrCreate(
                ['pertanyaan' => $row['pertanyaan']],
                ['jawaban' => $row['jawaban'], 'kategori' => $row['kategori'], 'aktif' => true],
            );
        }

        // --- Video YouTube (4) ---
        $videos = [
            ['judul' => 'Dokumentasi Umroh Reguler 9 Hari', 'url_youtube' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'deskripsi' => 'Keseruan dan kekhusyukan jamaah Asella selama 9 hari di Tanah Suci.'],
            ['judul' => 'Testimoni Jamaah Haji Khusus 2025', 'url_youtube' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'deskripsi' => 'Cerita jamaah haji khusus tentang pelayanan, tenda Arafah, dan pendampingan muthawwif.'],
            ['judul' => 'Panduan Manasik Umroh untuk Pemula', 'url_youtube' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'deskripsi' => 'Video panduan manasik: ihram, thawaf, sai, hingga tahallul.'],
            ['judul' => 'City Tour Thaif Bersama Asella', 'url_youtube' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'deskripsi' => 'Jelajah kota Thaif: Masjid Ibnu Abbas, pabrik parfum, dan kereta gantung.'],
        ];
        foreach ($videos as $i => $row) {
            VideoYoutube::firstOrCreate(
                ['judul' => $row['judul']],
                [
                    'url_youtube' => $row['url_youtube'],
                    'thumbnail' => 'https://picsum.photos/seed/asella-video-'.($i + 1).'/1280/720',
                    'deskripsi' => $row['deskripsi'],
                    'aktif' => true,
                ],
            );
        }

        $this->command->info('Konten: 6 artikel, 6 galeri, 6 testimoni, 6 FAQ, 4 video.');
    }
}
