<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\University;
use App\Models\Location;
use App\Models\Book;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default User
        User::factory()->create([
            'name' => 'Admin Perpustakaan USU',
            'email' => 'admin@usu.ac.id',
            'password' => bcrypt('password'),
        ]);

        // 2. Create University
        $usu = University::create([
            'code' => 'usu',
            'name' => 'Universitas Sumatera Utara',
            'logo_path' => 'logousu.jpeg',
        ]);

        // 3. Create Locations (19 Locations matching the statistics on landing page)
        $locationsData = [
            ['code' => 'perpustakaan_pusat', 'name' => 'Perpustakaan Universitas', 'icon' => 'ph-books'],
            ['code' => 'hukum', 'name' => 'Fakultas Hukum', 'icon' => 'ph-scales'],
            ['code' => 'ilmu_budaya', 'name' => 'Fakultas Ilmu Budaya', 'icon' => 'ph-mask-happy'],
            ['code' => 'ekonomi', 'name' => 'Fakultas Ekonomi dan Bisnis', 'icon' => 'ph-chart-line-up'],
            ['code' => 'kesehatan_masyarakat', 'name' => 'Fakultas Kesehatan Masyarakat', 'icon' => 'ph-heartbeat'],
            ['code' => 'pascasarjana', 'name' => 'Sekolah Pascasarjana', 'icon' => 'ph-graduation-cap'],
            ['code' => 'kedokteran', 'name' => 'Fakultas Kedokteran', 'icon' => 'ph-stethoscope'],
            ['code' => 'isip', 'name' => 'Fakultas ISIP', 'icon' => 'ph-users-three'],
            ['code' => 'out_of_stock', 'name' => 'Koleksi Out of Stock', 'icon' => 'ph-archive-tray'],
            ['code' => 'pertanian', 'name' => 'Fakultas Pertanian', 'icon' => 'ph-plant'],
            ['code' => 'keperawatan', 'name' => 'Fakultas Keperawatan', 'icon' => 'ph-first-aid'],
            ['code' => 'parlindungan', 'name' => 'AP. Parlindungan Collections', 'icon' => 'ph-books'],
            ['code' => 'mipa', 'name' => 'Fakultas MIPA', 'icon' => 'ph-test-tube'],
            ['code' => 'psikologi', 'name' => 'Fakultas Psikologi', 'icon' => 'ph-brain'],
            ['code' => 'sjahrir', 'name' => 'Sjahrir Corner Collections', 'icon' => 'ph-books'],
            ['code' => 'farmasi', 'name' => 'Fakultas Farmasi', 'icon' => 'ph-pill'],
            ['code' => 'kedokteran_gigi', 'name' => 'Fakultas Kedokteran Gigi', 'icon' => 'ph-tooth'],
            ['code' => 'kehutanan', 'name' => 'Fakultas Kehutanan', 'icon' => 'ph-tree'],
            ['code' => 'local_wisdom', 'name' => 'Local Wisdom', 'icon' => 'ph-map-trifold'],
        ];

        $locations = [];
        foreach ($locationsData as $loc) {
            $locations[$loc['code']] = Location::create([
                'university_id' => $usu->id,
                'code' => $loc['code'],
                'name' => $loc['name'],
                'icon' => $loc['icon'],
            ]);
        }

        // 4. Create 20 Realistic Books
        $booksData = [
            [
                'title' => 'Orang-orang yang disayangi Allah',
                'author' => 'Ali Akbar',
                'publisher' => 'Erlangga',
                'subject' => 'Islam, Karakter Islami, Keagamaan',
                'publish_year' => 2019,
                'isbn' => '978-602-241-112-3',
                'classification' => '297.313 Ali o',
                'category' => 'FAITH AND REASON ISLAM',
                'language' => 'Indonesia',
                'physical_description' => 'xvi, 210 hlm. : ilus. ; 21 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Elements of chemical reaction engineering. 7th Ed.',
                'author' => 'H. Scott Fogler',
                'publisher' => 'Prentice Hall',
                'subject' => 'Chemical Engineering, Chemical Reactions',
                'publish_year' => 2020,
                'isbn' => '978-013-388-751-9',
                'classification' => '660.2 Ele',
                'category' => 'CHEMICAL ENGINEERING',
                'language' => 'Inggris',
                'physical_description' => 'xxviii, 980 p. : ill. ; 26 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Membangun jembatan menuju kemandirian penyandang disabilitas',
                'author' => 'Sihar Sitorus',
                'publisher' => 'Gramedia Pustaka Utama',
                'subject' => 'Social Sciences, Disabilitas, Sosial Masyarakat',
                'publish_year' => 2021,
                'isbn' => '978-602-06-4921-5',
                'classification' => '305.908 Sir m',
                'category' => 'SOCIAL SCIENCE',
                'language' => 'Indonesia',
                'physical_description' => 'xx, 185 hlm. ; 23 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Pengantar Ilmu Hukum dan Tata Hukum Indonesia',
                'author' => 'Kansil, C.S.T.',
                'publisher' => 'Balai Pustaka',
                'subject' => 'Hukum Indonesia, Teori Hukum, Tata Hukum',
                'publish_year' => 2018,
                'isbn' => '978-979-407-154-9',
                'classification' => '340.1 Kan p',
                'category' => 'LAW',
                'language' => 'Indonesia',
                'physical_description' => 'x, 480 hlm. ; 21 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Sistem Informasi Manajemen: Mengelola Perusahaan Digital',
                'author' => 'Kenneth C. Laudon',
                'publisher' => 'Salemba Empat',
                'subject' => 'Sistem Informasi, Manajemen Bisnis, Digitalisasi',
                'publish_year' => 2020,
                'isbn' => '978-979-061-912-8',
                'classification' => '658.403 8 Lau s',
                'category' => 'MANAGEMENT',
                'language' => 'Indonesia',
                'physical_description' => 'xxiv, 520 hlm. : ilus. ; 26 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Metode Penelitian Hukum: Normatif dan Empiris',
                'author' => 'Prof. Soerjono Soekanto',
                'publisher' => 'Rajawali Pers',
                'subject' => 'Metodologi Penelitian, Hukum, Penelitian Normatif',
                'publish_year' => 2022,
                'isbn' => '978-979-421-042-0',
                'classification' => '340.072 Soe m',
                'category' => 'LAW',
                'language' => 'Indonesia',
                'physical_description' => 'xii, 192 hlm. ; 21 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Kalkulus Purcell Edisi 9 Jilid 1',
                'author' => 'Dale Varberg',
                'publisher' => 'Erlangga',
                'subject' => 'Matematika, Kalkulus, Integral dan Diferensial',
                'publish_year' => 2017,
                'isbn' => '978-979-015-821-4',
                'classification' => '515 Var k',
                'category' => 'MATHEMATICS',
                'language' => 'Indonesia',
                'physical_description' => 'xiv, 410 hlm. : ilus. ; 25 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Prinsip-Prinsip Biokimia (Lehninger Principles of Biochemistry)',
                'author' => 'David L. Nelson',
                'publisher' => 'Omega Press',
                'subject' => 'Biokimia, Biologi Molekuler, Kimia Organik',
                'publish_year' => 2019,
                'isbn' => '978-146-412-611-6',
                'classification' => '572 Nel p',
                'category' => 'BIOLOGY',
                'language' => 'Indonesia',
                'physical_description' => 'xxx, 1100 hlm. : ilus. ; 28 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Pengantar Teknologi Informasi Modern',
                'author' => 'Abdul Kadir',
                'publisher' => 'Andi Publisher',
                'subject' => 'Teknologi Informasi, Ilmu Komputer, Internet',
                'publish_year' => 2021,
                'isbn' => '978-623-01-0125-9',
                'classification' => '004 Kad p',
                'category' => 'COMPUTER SCIENCE',
                'language' => 'Indonesia',
                'physical_description' => 'x, 390 hlm. : ilus. ; 23 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Struktur Data dan Algoritma dengan Python',
                'author' => 'Rinaldi Munir',
                'publisher' => 'Informatika Bandung',
                'subject' => 'Pemrograman, Python, Struktur Data',
                'publish_year' => 2023,
                'isbn' => '978-623-7131-75-5',
                'classification' => '005.133 Mun s',
                'category' => 'COMPUTER SCIENCE',
                'language' => 'Indonesia',
                'physical_description' => 'viii, 320 hlm. ; 24 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Patologi Sosial 1: Masalah Sosial dan Penyimpangan',
                'author' => 'Kartini Kartono',
                'publisher' => 'Rajawali Pers',
                'subject' => 'Sosiologi, Masalah Sosial, Penyimpangan Perilaku',
                'publish_year' => 2018,
                'isbn' => '978-979-421-021-5',
                'classification' => '302.5 Kar p',
                'category' => 'SOCIAL SCIENCE',
                'language' => 'Indonesia',
                'physical_description' => 'xvi, 280 hlm. ; 21 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Makroekonomi Teori Pengantar Edisi Ketiga',
                'author' => 'Sadono Sukirno',
                'publisher' => 'RajaGrafindo Persada',
                'subject' => 'Ekonomi Makro, Kebijakan Fiskal, Pendapatan Nasional',
                'publish_year' => 2019,
                'isbn' => '978-979-421-413-8',
                'classification' => '339 Suk m',
                'category' => 'ECONOMICS',
                'language' => 'Indonesia',
                'physical_description' => 'xii, 450 hlm. ; 24 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Buku Ajar Fisiologi Kedokteran Guyton and Hall',
                'author' => 'John E. Hall',
                'publisher' => 'Elsevier Health Sciences',
                'subject' => 'Kedokteran, Fisiologi Tubuh, Anatomi',
                'publish_year' => 2021,
                'isbn' => '978-981-486-538-8',
                'classification' => '612 Hal b',
                'category' => 'MEDICINE',
                'language' => 'Indonesia',
                'physical_description' => 'xxvi, 1020 hlm. : ilus. ; 28 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Asuhan Keperawatan Jiwa dengan Pendekatan Klinis',
                'author' => 'Budi Anna Keliat',
                'publisher' => 'EGC',
                'subject' => 'Keperawatan Jiwa, Terapi Kognitif, Kesehatan Mental',
                'publish_year' => 2020,
                'isbn' => '978-979-044-901-5',
                'classification' => '610.736 Kel a',
                'category' => 'NURSING',
                'language' => 'Indonesia',
                'physical_description' => 'x, 240 hlm. ; 23 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Ilmu Kesehatan Masyarakat: Teori dan Aplikasi',
                'author' => 'Soekidjo Notoatmodjo',
                'publisher' => 'Rineka Cipta',
                'subject' => 'Kesehatan Masyarakat, Epidemiologi, Sanitasi Lingkungan',
                'publish_year' => 2018,
                'isbn' => '978-979-518-888-0',
                'classification' => '614 Not i',
                'category' => 'PUBLIC HEALTH',
                'language' => 'Indonesia',
                'physical_description' => 'viii, 340 hlm. ; 21 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Farmakologi Dasar dan Klinik Edisi 14',
                'author' => 'Bertram G. Katzung',
                'publisher' => 'EGC',
                'subject' => 'Farmasi, Farmakologi, Mekanisme Obat',
                'publish_year' => 2019,
                'isbn' => '978-979-044-998-5',
                'classification' => '615.1 Kat f',
                'category' => 'PHARMACY',
                'language' => 'Indonesia',
                'physical_description' => 'xxx, 1250 hlm. : ilus. ; 28 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Dasar-Dasar Kehutanan Tropis',
                'author' => 'H. Indriyanto',
                'publisher' => 'Bumi Aksara',
                'subject' => 'Kehutanan, Hutan Tropis, Ekologi Hutan',
                'publish_year' => 2017,
                'isbn' => '978-602-444-012-4',
                'classification' => '634.9 Ind d',
                'category' => 'FORESTRY',
                'language' => 'Indonesia',
                'physical_description' => 'xii, 290 hlm. ; 23 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Koleksi Emas Parada Harahap: Sejarah Pers Sumatera',
                'author' => 'Parada Harahap',
                'publisher' => 'Balai Pustaka',
                'subject' => 'Local Wisdom, Sejarah Pers, Sumatera Utara',
                'publish_year' => 1952,
                'isbn' => 'N/A - Arsip Pustaka',
                'classification' => '959.81 Har s',
                'category' => 'LOCAL WISDOM',
                'language' => 'Indonesia',
                'physical_description' => 'x, 150 hlm. ; 18 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Pertanian Berkelanjutan di Lahan Kering Tropis',
                'author' => 'Prof. Yusuf L. Limbongan',
                'publisher' => 'IPB Press',
                'subject' => 'Pertanian, Agronomi, Lahan Kering',
                'publish_year' => 2021,
                'isbn' => '978-623-256-421-2',
                'classification' => '630 Lim p',
                'category' => 'AGRICULTURE',
                'language' => 'Indonesia',
                'physical_description' => 'xiv, 220 hlm. ; 23 cm.',
                'type' => 'buku'
            ],
            [
                'title' => 'Konservasi Gigi Terpadu: Teori dan Aplikasi Praktis',
                'author' => 'Rasinta Tarigan',
                'publisher' => 'EGC',
                'subject' => 'Kedokteran Gigi, Konservasi Gigi, Karies',
                'publish_year' => 2018,
                'isbn' => '978-979-044-885-8',
                'classification' => '617.6 Tar k',
                'category' => 'DENTISTRY',
                'language' => 'Indonesia',
                'physical_description' => 'viii, 180 hlm. : ilus. ; 21 cm.',
                'type' => 'buku'
            ],
        ];

        foreach ($booksData as $index => $bData) {
            $book = Book::create($bData);

            // 5. Create 2-5 Physical Copy Items for each Book, scattered in different Locations
            // Assign specific location based on category, or fallback to perpustakaan_pusat
            $primaryLocCode = 'perpustakaan_pusat';
            $categoryLower = strtolower($bData['category']);
            if (str_contains($categoryLower, 'law')) {
                $primaryLocCode = 'hukum';
            } elseif (str_contains($categoryLower, 'social')) {
                $primaryLocCode = 'isip';
            } elseif (str_contains($categoryLower, 'management') || str_contains($categoryLower, 'economic')) {
                $primaryLocCode = 'ekonomi';
            } elseif (str_contains($categoryLower, 'computer') || str_contains($categoryLower, 'math') || str_contains($categoryLower, 'biology')) {
                $primaryLocCode = 'mipa';
            } elseif (str_contains($categoryLower, 'medicine')) {
                $primaryLocCode = 'kedokteran';
            } elseif (str_contains($categoryLower, 'nursing')) {
                $primaryLocCode = 'keperawatan';
            } elseif (str_contains($categoryLower, 'public health')) {
                $primaryLocCode = 'kesehatan_masyarakat';
            } elseif (str_contains($categoryLower, 'pharmacy')) {
                $primaryLocCode = 'farmasi';
            } elseif (str_contains($categoryLower, 'forestry')) {
                $primaryLocCode = 'kehutanan';
            } elseif (str_contains($categoryLower, 'wisdom') || str_contains($categoryLower, 'local')) {
                $primaryLocCode = 'local_wisdom';
            } elseif (str_contains($categoryLower, 'agriculture')) {
                $primaryLocCode = 'pertanian';
            } elseif (str_contains($categoryLower, 'dentistry')) {
                $primaryLocCode = 'kedokteran_gigi';
            }

            // Let's create copies
            $numCopies = rand(2, 4);
            for ($c = 1; $c <= $numCopies; $c++) {
                // First copy is always at the primary location
                // Subsequent copies could be at perpustakaan_pusat or other matching library
                $locObj = ($c == 1) ? $locations[$primaryLocCode] : $locations['perpustakaan_pusat'];
                
                // Realistic barcode: e.g. 1020210001
                $barcode = '10' . ($book->publish_year) . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . $c;
                // Realistic call number: e.g. 340.1 Kan p c.1
                $callNumber = $book->classification . ' c.' . $c;
                // Status: 80% Tersedia, 20% Dipinjam
                $status = (rand(1, 10) <= 8) ? 'Tersedia' : 'Dipinjam';

                Item::create([
                    'book_id' => $book->id,
                    'location_id' => $locObj->id,
                    'barcode' => $barcode,
                    'call_number' => $callNumber,
                    'status' => $status,
                ]);
            }
        }
    }
}
