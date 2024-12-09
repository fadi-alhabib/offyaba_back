<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    private array $names = [
        'Restaurant',
        'Pharmacy',
        'Store',
        'Shoe Store',
        'Clothing Store',
    ];

    public function run(): void
    {
        foreach ($this->names as $name) {
            Section::query()->create([
                'name' => $name
            ]);
        }
    }
}
