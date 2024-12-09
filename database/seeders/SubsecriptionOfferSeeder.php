<?php

namespace Database\Seeders;

use App\Models\SubscriptionOffer;
use Illuminate\Database\Seeder;

class SubsecriptionOfferSeeder extends Seeder
{
    private $offers = [
        [
            'period' => 1,
            'cost' => 5000,
            'number_of_usage' => 10,
            'discount' => 0,
        ],
        [
            'period' => 3,
            'cost' => 5000,
            'number_of_usage' => 30,
            'discount' => 10,
        ],
        [
            'period' => 6,
            'cost' => 5000,
            'number_of_usage' => 60,
            'discount' => 20,
        ]
    ];

    public function run(): void
    {
        foreach ($this->offers as $offer) {
            SubscriptionOffer::query()
                ->create($offer);
        }
    }
}
