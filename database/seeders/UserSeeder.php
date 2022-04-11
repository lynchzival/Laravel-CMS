<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin'),
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Author',
            'email' => 'author@email.com',
            'password' => bcrypt('author'),
            'role_id' => 2,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Reader',
            'email' => 'reader@email.com',
            'password' => bcrypt('reader'),
            'role_id' => 3,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
