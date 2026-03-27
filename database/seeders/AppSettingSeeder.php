<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'rfid_checkin_start',
                'value' => '05:30',
                'type' => 'time',
                'description' => 'Jam awal mesin presensi mulai menerima tap kartu untuk kedatangan pagi.'
            ],
            [
                'key' => 'rfid_late_threshold',
                'value' => '07:15',
                'type' => 'time',
                'description' => 'Batas waktu maksimal untuk dicatat sebagai hadir (tap RFID). Setelah ini, dihitung terlambat.'
            ],
            [
                'key' => 'rfid_checkin_end',
                'value' => '08:00',
                'type' => 'time',
                'description' => 'Batas penutupan penerimaan absensi kedatangan harian.'
            ],
            [
                'key' => 'rfid_checkout_start',
                'value' => '13:00',
                'type' => 'time',
                'description' => 'Jam awal mesin presensi mulai menerima tap absensi pulang.'
            ],
            [
                'key' => 'rfid_checkout_end',
                'value' => '17:00',
                'type' => 'time',
                'description' => 'Batas akhir waktu operasional mesin untuk penerimaan absensi pulang.'
            ],
            [
                'key' => 'msg_checkin_success',
                'value' => 'Berhasil Absen Masuk',
                'type' => 'string',
                'description' => 'Pesan feedback saat scan absen kedatangan berhasil.'
            ],
            [
                'key' => 'msg_checkout_success',
                'value' => 'Berhasil Absen Pulang',
                'type' => 'string',
                'description' => 'Pesan feedback saat scan absen kepulangan berhasil.'
            ],
            [
                'key' => 'msg_unregistered_card',
                'value' => 'Kartu Tidak Dikenali!',
                'type' => 'string',
                'description' => 'Pesan error saat kartu yang di-tap tidak ditemukan di database.'
            ],
            [
                'key' => 'msg_outside_hours',
                'value' => 'Di Luar Jam Presensi',
                'type' => 'string',
                'description' => 'Pesan error saat santri melakukan scan di luar jam masuk dan jam pulang yang ditentukan.'
            ],
            [
                'key' => 'journal_open_time',
                'value' => '07:00',
                'type' => 'time',
                'description' => 'Jam mulai guru diizinkan untuk mengisi jurnal mengajar harian.'
            ],
            [
                'key' => 'journal_close_time',
                'value' => '16:00',
                'type' => 'time',
                'description' => 'Batas akhir guru diizinkan untuk mengisi jurnal. Lewat jam ini, pengisian dikunci.'
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\AppSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
