<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentTypes = [
            [
                'nama' => 'SPP Bulanan',
                'nominal' => 250000,
                'jatuh_tempo_hari' => 10,
                'is_monthly' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Uang Makan',
                'nominal' => 500000,
                'jatuh_tempo_hari' => 10,
                'is_monthly' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Uang Laundry',
                'nominal' => 100000,
                'jatuh_tempo_hari' => 10,
                'is_monthly' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Uang Asrama',
                'nominal' => 200000,
                'jatuh_tempo_hari' => 10,
                'is_monthly' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Dana Kegiatan',
                'nominal' => 150000,
                'jatuh_tempo_hari' => 10,
                'is_monthly' => false,
                'is_active' => true,
            ],
        ];

        foreach ($paymentTypes as $type) {
            PaymentType::updateOrCreate(
                ['nama' => $type['nama']],
                $type
            );
        }
    }
}
