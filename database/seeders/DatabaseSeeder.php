<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Plan;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this -> call(CategorySeeder::class);
        $this -> call(RoleSeeder::class);
        $this -> call(UserSeeder::class);
        $this -> call(ArticleSeeder::class);
        $this -> call(PlanSeeder::class);
        $this -> call(PremiumArticleSeeder::class);
    }
}
