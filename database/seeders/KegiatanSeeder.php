<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kegiatans = [
            [
                'nama_kegiatan' => 'Pramuka',
                'deskripsi' => 'Ekstrakurikuler Wajib Pramuka',
                'is_active' => true,
            ],
            [
                'nama_kegiatan' => 'Pencak Silat',
                'deskripsi' => 'Ekstrakurikuler Bela Diri Pencak Silat',
                'is_active' => true,
            ],
            [
                'nama_kegiatan' => 'Olimpiade Sains',
                'deskripsi' => 'Bimbingan Khusus Olimpiade',
                'is_active' => true,
            ],
            [
                'nama_kegiatan' => 'LDKS',
                'deskripsi' => 'Latihan Dasar Kepemimpinan',
                'is_active' => true,
            ]
        ];

        foreach ($kegiatans as $kegiatan) {
            Kegiatan::create($kegiatan);
        }
    }
}
