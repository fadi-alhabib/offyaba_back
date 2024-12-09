<?php

namespace Database\Seeders;

use App\Models\QrCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QrCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 2; $i++) {
            QrCode::query()->create([
                'user_id' => 9,
                'expiration_date' => '2024-6-20',
                'period' => 2,
                'number_of_usage' => 15,
            ]);
        }
    }
}
