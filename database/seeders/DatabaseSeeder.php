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
                'title' => 'Selamat Datang di Pondok Pesantren Nurul Hidayah',
                'subtitle' => 'Membentuk Generasi Qurani yang Berakhlak Mulia, Berwawasan Luas, dan Siap Menghadapi Tantangan Zaman',
                'image' => 'https://images.unsplash.com/photo-1585036156171-384164a8c675?w=1920',
                'cta_text' => 'Daftar PPDB',
                'cta_link' => '/ppdb',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Program Tahfidz 30 Juz',
                'subtitle' => 'Dengan metode pembelajaran modern dan bimbingan ustadz berpengalaman',
                'image' => 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?w=1920',
                'cta_text' => 'Pelajari Program',
                'cta_link' => '#programs',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
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
