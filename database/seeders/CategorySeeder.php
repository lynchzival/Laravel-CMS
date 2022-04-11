<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Sport',
            'description' => 'Sport articles',
            'slug' => 'sport'
        ]);

        Category::create([
            'name' => 'Politics',
            'description' => 'Politics articles',
            'slug' => 'politics'
        ]);

        Category::create([
            'name' => 'Technology',
            'description' => 'Technology articles',
            'slug' => 'technology'
        ]);
    }
}
