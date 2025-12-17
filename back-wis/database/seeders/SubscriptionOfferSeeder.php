<?php

namespace Database\Seeders;

use App\Enums\OfferType;
use App\Models\SubscriptionOffer;
use Illuminate\Database\Seeder;

class SubscriptionOfferSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionOffer::insert([
            [
                'name' => 'Basic',
                'description' => 'Free plan for small recruiters',
                'price' => 0,
                'max_jobs'=> 3,
                'offer_type' => OfferType::BASIC,
            ],
            [
                'name' => 'Premium',
                'description' => 'Professional plan with advanced features',
                'price' => 10000,
                'max_jobs'=> 6,
                'offer_type' => OfferType::PREMIUM,
            ],
            [
                'name' => 'Unlimited',
                'description' => 'Enterprise plan with unlimited job postings',
                'price' => 20000,
                'max_jobs'=> -1,
                'offer_type' => OfferType::UNLIMITED,
            ],

        ]);
    }
}
