<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'lastname' => 'Admin',
            'firstname' => 'User',
            'nickname' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'site_web' => 'https://breitling-league.com',
            'points' => 1000,
            'rank_id' => null, // À définir plus tard quand vous aurez des rangs
            'profile_complete' => true,
            'isActive' => true,
            'registrationKeyId' => null,
        ]);
    }
}
