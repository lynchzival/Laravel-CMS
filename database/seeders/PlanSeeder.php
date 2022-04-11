<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Monthly Plan',
            'slug' => 'monthly-plan',
            'stripe_id' => 'price_1KdrOmAgZT1cNbtNABOmpiCT',
            'stripe_name' => 'monthly',
            'price' => 2.99,
            'abbreviation' => '/month',
        ]);

        Plan::create([
            'name' => 'Yearly Plan',
            'slug' => 'yearly-plan',
            'stripe_id' => 'price_1KdrPCAgZT1cNbtNYjSfqneU',
            'stripe_name' => 'yearly',
            'price' => 29.99,
            'abbreviation' => '/year',
        ]);
    }
}
