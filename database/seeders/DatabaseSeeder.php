<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Wali;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\SiteSetting;
use App\Models\Banner;
use App\Models\Announcement;
use App\Models\LandingPageContent;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Site Settings
        $this->seedSiteSettings();
        
        // 2. Banners
        $this->seedBanners();

        // 2b. Landing Page CMS Content
        $this->seedLandingPageContent();

        // 2c. Programs
        $this->seedPrograms();
        
        // 3. Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@ponspes.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 4. Operator User
        User::create([
            'name' => 'Operator Pesantren',
            'email' => 'operator@ponspes.test',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'is_active' => true,
        ]);

        // 5. Mapel (Mata Pelajaran)
        $mapels = $this->seedMapels();

        // 6. Kelas
        $kelasList = $this->seedKelas();

        // 7. Guru/Ustadz
        $gurus = $this->seedGurus();

        // 8. Wali Santri
        $walis = $this->seedWalis();

        // 9. Santri
        $this->seedSantris($kelasList, $walis);

        // 10. Jadwal
        $this->seedJadwals($gurus, $kelasList, $mapels);

        // 11. Announcements
        $this->seedAnnouncements();

        $this->command->info('Database seeded successfully!');
    }

    private function seedSiteSettings(): void
    {
        $settings = [
            ['key' => 'nama_pondok', 'value' => 'Pondok Pesantren Nurul Hidayah', 'type' => 'text', 'group' => 'general'],
            ['key' => 'tagline', 'value' => 'Membentuk Generasi Qurani yang Berakhlak Mulia', 'type' => 'text', 'group' => 'general'],
            ['key' => 'alamat', 'value' => 'Jl. Pesantren No. 123, Kabupaten Bandung, Jawa Barat 40123', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'telepon', 'value' => '(022) 1234567', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '6281234567890', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'info@nurulhidayah.sch.id', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'tahun_berdiri', 'value' => '1995', 'type' => 'text', 'group' => 'general'],
            ['key' => 'jumlah_santri', 'value' => '500', 'type' => 'text', 'group' => 'stats'],
            ['key' => 'jumlah_guru', 'value' => '45', 'type' => 'text', 'group' => 'stats'],
            ['key' => 'jumlah_hafidz', 'value' => '120', 'type' => 'text', 'group' => 'stats'],
            ['key' => 'visi', 'value' => 'Menjadi lembaga pendidikan Islam terdepan yang melahirkan generasi Qurani, berilmu, berakhlak mulia, dan berwawasan global.', 'type' => 'text', 'group' => 'about'],
            ['key' => 'misi', 'value' => json_encode([
                'Menyelenggarakan pendidikan tahfidz Al-Quran dengan metode modern',
                'Memadukan kurikulum pesantren dengan kurikulum nasional',
                'Membentuk karakter santri yang berakhlakul karimah',
                'Mengembangkan bakat dan potensi santri secara optimal',
                'Mempersiapkan santri untuk menghadapi tantangan global'
            ]), 'type' => 'json', 'group' => 'about'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }

    private function seedBanners(): void
    {
        $banners = [
            [
                'title' => 'Mewujudkan Generasi Rabbani',
                'subtitle' => 'Pondok Pesantren Pancasila Reo mencetak kader ulama intelek yang berakhlak mulia dan berwawasan luas.',
                'image' => 'cms/banners/hero-1.png',
                'cta_text' => 'DAFTAR SANTRI BARU 2026/2027',
                'cta_link' => '/ppdb',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Program Tahfidz 30 Juz',
                'subtitle' => 'Dengan metode pembelajaran modern dan bimbingan ustadz berpengalaman',
                'image' => 'cms/banners/hero-2.png',
                'cta_text' => 'Pelajari Program',
                'cta_link' => '#program',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }

    private function seedLandingPageContent(): void
    {
        $contents = [
            // Hero
            ['key' => 'hero_title', 'value' => 'Mewujudkan Generasi Rabbani', 'type' => 'text', 'section' => 'hero'],
            ['key' => 'hero_subtitle', 'value' => 'Pondok Pesantren Pancasila Reo mencetak kader ulama intelek yang berakhlak mulia dan berwawasan luas.', 'type' => 'text', 'section' => 'hero'],
            ['key' => 'hero_image', 'value' => 'cms/hero/hero-bg.png', 'type' => 'image', 'section' => 'hero'],

            // About
            ['key' => 'about_title', 'value' => 'Membangun Peradaban dengan Al-Qur\'an dan Sunnah', 'type' => 'text', 'section' => 'about'],
            ['key' => 'about_text', 'value' => 'Pondok Pesantren Pancasila Reo adalah lembaga pendidikan Islam modern yang memadukan kurikulum nasional dengan kurikulum pesantren salaf. Kami bertekad melahirkan generasi yang tidak hanya cerdas secara intelektual, tetapi juga memiliki kedalaman spiritual dan akhlak mulia.', 'type' => 'text', 'section' => 'about'],
            ['key' => 'about_image', 'value' => 'cms/about/about.png', 'type' => 'image', 'section' => 'about'],

            // Statistics
            ['key' => 'stat_santri', 'value' => '500+', 'type' => 'text', 'section' => 'statistics'],
            ['key' => 'stat_alumni', 'value' => '1.200+', 'type' => 'text', 'section' => 'statistics'],
            ['key' => 'stat_pengajar', 'value' => '45+', 'type' => 'text', 'section' => 'statistics'],
            ['key' => 'stat_akreditasi', 'value' => 'A', 'type' => 'text', 'section' => 'statistics'],

            // Vision
            ['key' => 'vision_text', 'value' => '"Wujudkan generasi islami berkarakter yang seimbang secara spiritual, intelektual, moral dan keterampilan, ber-tafaqquh fiddin sebagai kader umat yang rahmatan lil alamin."', 'type' => 'text', 'section' => 'vision'],
            ['key' => 'vision_subtext', 'value' => 'Visi Pondok Pesantren Pancasila Reo', 'type' => 'text', 'section' => 'vision'],

            // Contact
            ['key' => 'contact_address', 'value' => 'Jl. Pesantren No. 1, Reo, Kab. Manggarai, NTT', 'type' => 'text', 'section' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+62 812 3456 7890', 'type' => 'text', 'section' => 'contact'],
            ['key' => 'contact_email', 'value' => 'info@ponpespanscasilareo.sch.id', 'type' => 'text', 'section' => 'contact'],

            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/ponpespancasilareo', 'type' => 'text', 'section' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/ponpespancasilareo', 'type' => 'text', 'section' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@ponpespancasilareo', 'type' => 'text', 'section' => 'social'],
            ['key' => 'social_whatsapp', 'value' => '6281234567890', 'type' => 'text', 'section' => 'social'],

            // Footer
            ['key' => 'footer_text', 'value' => 'Mewujudkan generasi Islam yang kaffah, berilmu, dan berakhlak mulia untuk kemajuan umat dan bangsa.', 'type' => 'text', 'section' => 'footer'],

            // Map
            ['key' => 'map_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.4!2d120.4!3d-8.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwMzYnMDAuMCJTIDEyMMKwMjQnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890', 'type' => 'text', 'section' => 'map'],

            // Testimonials
            ['key' => 'testimonials', 'value' => json_encode([
                ['name' => 'H. Abdul Karim', 'text' => 'Alhamdulillah, anak saya mendapat bimbingan yang sangat baik di Ponpes Pancasila Reo. Akhlak dan hafalannya meningkat pesat.', 'role' => 'Wali Santri'],
                ['name' => 'Ustadzah Maryam', 'text' => 'Lingkungan yang kondusif dan kurikulum terpadu menjadikan santri-santri mampu berprestasi di bidang akademik dan agama.', 'role' => 'Alumni Pengajar'],
                ['name' => 'Muhammad Faris', 'text' => 'Saya bangga menjadi alumni Ponpes Pancasila Reo. Ilmu yang saya dapatkan sangat bermanfaat untuk kehidupan saya sekarang.', 'role' => 'Alumni 2020'],
            ]), 'type' => 'json', 'section' => 'testimonials'],

            // Achievements
            ['key' => 'achievements', 'value' => json_encode([
                ['title' => 'Juara 1 MTQ Tingkat Provinsi NTT', 'year' => '2025', 'description' => 'Cabang Tilawatil Quran putra berhasil meraih juara pertama.'],
                ['title' => 'Juara 2 Olimpiade Matematika', 'year' => '2025', 'description' => 'Tingkat Kabupaten Manggarai dalam ajang Kompetisi Sains Nasional.'],
                ['title' => 'Akreditasi A', 'year' => '2024', 'description' => 'Mendapatkan akreditasi A dari BAN-S/M untuk standar pendidikan nasional.'],
            ]), 'type' => 'json', 'section' => 'achievements'],
        ];

        foreach ($contents as $content) {
            LandingPageContent::create($content);
        }
    }

    private function seedPrograms(): void
    {
        $programs = [
            [
                'title' => 'Tahfidzul Qur\'an',
                'slug' => 'tahfidzul-quran',
                'description' => 'Program unggulan menghafal Al-Qur\'an 30 Juz dengan sanad bersambung dan metode mutqin.',
                'icon' => 'book-open',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Pendidikan Umum & Agama',
                'slug' => 'pendidikan-umum-agama',
                'description' => 'Kurikulum terpadu yang memadukan ilmu umum dan pendidikan agama Islam secara seimbang.',
                'icon' => 'academic-cap',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Pembinaan Karakter',
                'slug' => 'pembinaan-karakter',
                'description' => 'Membentuk karakter santri yang mandiri, disiplin, dan berakhlakul karimah melalui kegiatan harian.',
                'icon' => 'users',
                'is_featured' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }

    private function seedMapels(): array
    {
        $mapels = [
            ['kode' => 'TFZ', 'nama' => 'Tahfidzul Quran', 'kategori' => 'tahfidz', 'kkm' => 75],
            ['kode' => 'FQH', 'nama' => 'Fiqih', 'kategori' => 'agama', 'kkm' => 70],
            ['kode' => 'AQD', 'nama' => 'Aqidah Akhlak', 'kategori' => 'agama', 'kkm' => 70],
            ['kode' => 'ARB', 'nama' => 'Bahasa Arab', 'kategori' => 'agama', 'kkm' => 70],
            ['kode' => 'QHD', 'nama' => 'Quraan Hadits', 'kategori' => 'agama', 'kkm' => 70],
            ['kode' => 'MTK', 'nama' => 'Matematika', 'kategori' => 'umum', 'kkm' => 70],
            ['kode' => 'IPA', 'nama' => 'Ilmu Pengetahuan Alam', 'kategori' => 'umum', 'kkm' => 70],
            ['kode' => 'IPS', 'nama' => 'Ilmu Pengetahuan Sosial', 'kategori' => 'umum', 'kkm' => 70],
            ['kode' => 'BIN', 'nama' => 'Bahasa Indonesia', 'kategori' => 'umum', 'kkm' => 70],
            ['kode' => 'ENG', 'nama' => 'Bahasa Inggris', 'kategori' => 'umum', 'kkm' => 70],
        ];

        $created = [];
        foreach ($mapels as $mapel) {
            $created[] = Mapel::create($mapel);
        }
        return $created;
    }

    private function seedKelas(): array
    {
        $kelasList = [
            ['nama_kelas' => 'VII A', 'tingkat' => 7, 'tahun_ajaran' => '2024/2025'],
            ['nama_kelas' => 'VII B', 'tingkat' => 7, 'tahun_ajaran' => '2024/2025'],
            ['nama_kelas' => 'VIII A', 'tingkat' => 8, 'tahun_ajaran' => '2024/2025'],
            ['nama_kelas' => 'VIII B', 'tingkat' => 8, 'tahun_ajaran' => '2024/2025'],
            ['nama_kelas' => 'IX A', 'tingkat' => 9, 'tahun_ajaran' => '2024/2025'],
            ['nama_kelas' => 'IX B', 'tingkat' => 9, 'tahun_ajaran' => '2024/2025'],
        ];

        $created = [];
        foreach ($kelasList as $kelas) {
            $created[] = Kelas::create($kelas);
        }
        return $created;
    }

    private function seedGurus(): array
    {
        $guruData = [
            ['nama' => 'Ustadz Ahmad Fauzi, Lc., M.A.', 'nip' => 'NIP001', 'jabatan' => 'Kepala Pondok', 'bidang' => 'Tahfidz & Fiqih', 'show' => true],
            ['nama' => 'Ustadz Muhammad Rizki, S.Pd.I', 'nip' => 'NIP002', 'jabatan' => 'Wakil Kepala', 'bidang' => 'Bahasa Arab', 'show' => true],
            ['nama' => 'Ustadzah Fatimah Az-Zahra, S.Ag', 'nip' => 'NIP003', 'jabatan' => 'Guru', 'bidang' => 'Aqidah Akhlak', 'show' => true],
            ['nama' => 'Ustadz Hasan Al-Banna, M.Pd', 'nip' => 'NIP004', 'jabatan' => 'Guru', 'bidang' => 'Tahfidz', 'show' => true],
            ['nama' => 'Pak Budi Santoso, S.Pd', 'nip' => 'NIP005', 'jabatan' => 'Guru', 'bidang' => 'Matematika', 'show' => false],
            ['nama' => 'Ibu Siti Aminah, S.Pd', 'nip' => 'NIP006', 'jabatan' => 'Guru', 'bidang' => 'Bahasa Indonesia', 'show' => false],
        ];

        $gurus = [];
        foreach ($guruData as $index => $data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => 'guru' . ($index + 1) . '@ponspes.test',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'is_active' => true,
            ]);

            $gurus[] = Guru::create([
                'user_id' => $user->id,
                'nip' => $data['nip'],
                'nama_lengkap' => $data['nama'],
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => fake()->dateTimeBetween('-50 years', '-25 years'),
                'jenis_kelamin' => str_contains($data['nama'], 'Ustadzah') || str_contains($data['nama'], 'Ibu') ? 'P' : 'L',
                'alamat' => fake()->address(),
                'no_hp' => fake()->phoneNumber(),
                'jabatan' => $data['jabatan'],
                'bidang_keahlian' => $data['bidang'],
                'show_on_landing' => $data['show'],
                'status' => 'aktif',
            ]);
        }

        return $gurus;
    }

    private function seedWalis(): array
    {
        $waliData = [
            ['nama' => 'H. Abdul Rahman', 'hubungan' => 'ayah', 'pekerjaan' => 'Pengusaha'],
            ['nama' => 'Hj. Siti Maryam', 'hubungan' => 'ibu', 'pekerjaan' => 'Ibu Rumah Tangga'],
            ['nama' => 'Ahmad Syafii', 'hubungan' => 'ayah', 'pekerjaan' => 'PNS'],
            ['nama' => 'Fatimah Zahra', 'hubungan' => 'ibu', 'pekerjaan' => 'Guru'],
            ['nama' => 'Muhammad Yusuf', 'hubungan' => 'wali', 'pekerjaan' => 'Wiraswasta'],
        ];

        $walis = [];
        foreach ($waliData as $index => $data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => 'wali' . ($index + 1) . '@ponspes.test',
                'password' => Hash::make('password'),
                'role' => 'wali',
                'is_active' => true,
            ]);

            $walis[] = Wali::create([
                'user_id' => $user->id,
                'nama_lengkap' => $data['nama'],
                'hubungan' => $data['hubungan'],
                'no_hp' => fake()->phoneNumber(),
                'alamat' => fake()->address(),
                'pekerjaan' => $data['pekerjaan'],
            ]);
        }

        return $walis;
    }

    private function seedSantris(array $kelasList, array $walis): void
    {
        $santriNames = [
            'Muhammad Fadlan', 'Ahmad Zaki', 'Umar Al-Faruq', 'Ali Imran', 'Hasan Al-Basri',
            'Husain Abdullah', 'Bilal Ibrahim', 'Khalid Walid', 'Salman Al-Farisi', 'Abdullah Azzam',
            'Aisyah Putri', 'Fatimah Azzahra', 'Khadijah Aminah', 'Hafsah Nurul', 'Zainab Salsabila',
        ];

        foreach ($santriNames as $index => $nama) {
            $user = User::create([
                'name' => $nama,
                'email' => 'santri' . ($index + 1) . '@ponspes.test',
                'password' => Hash::make('password'),
                'role' => 'santri',
                'is_active' => true,
            ]);

            $kelas = $kelasList[$index % count($kelasList)];
            $wali = $walis[$index % count($walis)];
            $jk = str_contains($nama, 'Aisyah') || str_contains($nama, 'Fatimah') || 
                  str_contains($nama, 'Khadijah') || str_contains($nama, 'Hafsah') || 
                  str_contains($nama, 'Zainab') ? 'P' : 'L';

            Santri::create([
                'user_id' => $user->id,
                'nis' => sprintf('2024%04d', $index + 1),
                'nisn' => sprintf('00%08d', $index + 1),
                'nama_lengkap' => $nama,
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->dateTimeBetween('-15 years', '-12 years'),
                'jenis_kelamin' => $jk,
                'alamat' => fake()->address(),
                'no_hp' => fake()->phoneNumber(),
                'kelas_id' => $kelas->id,
                'wali_id' => $wali->id,
                'tahun_masuk' => 2024,
                'status' => 'aktif',
            ]);
        }
    }

    private function seedJadwals(array $gurus, array $kelasList, array $mapels): void
    {
        $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        $jamMulai = ['07:00', '08:30', '10:00', '13:00', '14:30'];

        foreach ($kelasList as $kelas) {
            foreach ($hari as $h) {
                if ($h === 'jumat' || $h === 'sabtu') continue;
                
                $usedMapels = [];
                foreach ($jamMulai as $index => $jam) {
                    $mapel = $mapels[array_rand($mapels)];
                    while (in_array($mapel->id, $usedMapels) && count($usedMapels) < count($mapels)) {
                        $mapel = $mapels[array_rand($mapels)];
                    }
                    $usedMapels[] = $mapel->id;

                    Jadwal::create([
                        'guru_id' => $gurus[array_rand($gurus)]->id,
                        'kelas_id' => $kelas->id,
                        'mapel_id' => $mapel->id,
                        'hari' => $h,
                        'jam_mulai' => $jam,
                        'jam_selesai' => date('H:i', strtotime($jam) + 5400),
                        'tahun_ajaran' => '2024/2025',
                    ]);
                }
            }
        }
    }

    private function seedAnnouncements(): void
    {
        Announcement::create([
            'title' => 'Pendaftaran Santri Baru Tahun Ajaran 2025/2026',
            'content' => 'Pendaftaran santri baru untuk tahun ajaran 2025/2026 telah dibuka. Segera daftarkan putra-putri Anda melalui portal PPDB online kami.',
            'type' => 'info',
            'for_roles' => null,
            'published_at' => now(),
            'is_active' => true,
        ]);

        Announcement::create([
            'title' => 'Libur Semester Ganjil',
            'content' => 'Libur semester ganjil akan berlangsung dari tanggal 20 Desember 2024 hingga 5 Januari 2025.',
            'type' => 'info',
            'for_roles' => ['santri', 'wali', 'guru'],
            'published_at' => now(),
            'is_active' => true,
        ]);
    }
}
