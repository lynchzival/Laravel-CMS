<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        Role::create([
            'name' => 'Author',
            'slug' => 'author',
        ]);

        Role::create([
            'name' => 'Reader',
            'slug' => 'reader',
        ]);
    }
}
