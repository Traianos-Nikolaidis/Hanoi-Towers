<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => 'superadmin'
        ]);

        User::factory()->count(5)->create(['role' => 'admin']);
        User::factory()->count(5)->create(['role' => 'professor']);
        User::factory()->count(5)->create(['role' => 'student']);
    }
}
