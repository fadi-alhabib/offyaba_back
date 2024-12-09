<?php

namespace Database\Seeders;

use App\Models\ClothingItem;
use App\Models\ClothingType;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClothingTypeSeeder extends Seeder
{
    private array $types = [
        'T-Shirt',
        'Shoe',
        'Pants',
        'Skirt',
        'Socks',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        foreach ($this->types as $type) {
//            ClothingType::create([
//                'name' => $type
//            ]);
//        }
        ClothingItem::factory(20)
            ->forItem()
            ->create();
    }
}
