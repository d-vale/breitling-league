<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = Rank::all();

        $users = [
            // Admin/Master users
            [
                'name' => 'Admin User',
                'lastname' => 'Admin',
                'firstname' => 'Super',
                'nickname' => 'admin',
                'email' => 'admin@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => 'https://breitling-league.com',
                'points' => 1500000,
                'rank_id' => $ranks->where('name', 'Timekeeper')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            // Experts/Diamond tier
            [
                'name' => 'Sarah Johnson',
                'lastname' => 'Johnson',
                'firstname' => 'Sarah',
                'nickname' => 'sarah_pilot',
                'email' => 'sarah.johnson@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => 'https://aviationexpert.com',
                'points' => 450000,
                'rank_id' => $ranks->where('name', 'Diamond')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            [
                'name' => 'Marcus Weber',
                'lastname' => 'Weber',
                'firstname' => 'Marcus',
                'nickname' => 'marcus_chrono',
                'email' => 'marcus.weber@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 380000,
                'rank_id' => $ranks->where('name', 'Diamond')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            // Platinum tier users
            [
                'name' => 'Elena Rodriguez',
                'lastname' => 'Rodriguez',
                'firstname' => 'Elena',
                'nickname' => 'elena_diver',
                'email' => 'elena.rodriguez@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => 'https://diving-pro.com',
                'points' => 220000,
                'rank_id' => $ranks->where('name', 'Platinum')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            [
                'name' => 'Thomas Chen',
                'lastname' => 'Chen',
                'firstname' => 'Thomas',
                'nickname' => 'thomas_tech',
                'email' => 'thomas.chen@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 180000,
                'rank_id' => $ranks->where('name', 'Platinum')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            // Gold tier users
            [
                'name' => 'Marie Dubois',
                'lastname' => 'Dubois',
                'firstname' => 'Marie',
                'nickname' => 'marie_collector',
                'email' => 'marie.dubois@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => 'https://watch-collector.fr',
                'points' => 120000,
                'rank_id' => $ranks->where('name', 'Gold')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            [
                'name' => 'David Thompson',
                'lastname' => 'Thompson',
                'firstname' => 'David',
                'nickname' => 'david_sales',
                'email' => 'david.thompson@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 95000,
                'rank_id' => $ranks->where('name', 'Gold')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            [
                'name' => 'Anna Kowalski',
                'lastname' => 'Kowalski',
                'firstname' => 'Anna',
                'nickname' => 'anna_heritage',
                'email' => 'anna.kowalski@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 88000,
                'rank_id' => $ranks->where('name', 'Gold')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            // Silver tier users
            [
                'name' => 'James Miller',
                'lastname' => 'Miller',
                'firstname' => 'James',
                'nickname' => 'james_newbie',
                'email' => 'james.miller@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 45000,
                'rank_id' => $ranks->where('name', 'Silver')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            [
                'name' => 'Lisa Anderson',
                'lastname' => 'Anderson',
                'firstname' => 'Lisa',
                'nickname' => 'lisa_boutique',
                'email' => 'lisa.anderson@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => 'https://luxury-boutique.com',
                'points' => 52000,
                'rank_id' => $ranks->where('name', 'Silver')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            [
                'name' => 'Roberto Silva',
                'lastname' => 'Silva',
                'firstname' => 'Roberto',
                'nickname' => 'roberto_brasil',
                'email' => 'roberto.silva@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 38000,
                'rank_id' => $ranks->where('name', 'Silver')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            // Bronze tier users (débutants)
            [
                'name' => 'Sophie Martin',
                'lastname' => 'Martin',
                'firstname' => 'Sophie',
                'nickname' => 'sophie_trainee',
                'email' => 'sophie.martin@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 15000,
                'rank_id' => $ranks->where('name', 'Bronze')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            [
                'name' => 'Michael Brown',
                'lastname' => 'Brown',
                'firstname' => 'Michael',
                'nickname' => 'mike_rookie',
                'email' => 'michael.brown@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 8500,
                'rank_id' => $ranks->where('name', 'Bronze')->first()->id,
                'profile_complete' => false, // Profil incomplet
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            [
                'name' => 'Yuki Tanaka',
                'lastname' => 'Tanaka',
                'firstname' => 'Yuki',
                'nickname' => 'yuki_japan',
                'email' => 'yuki.tanaka@breitling.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 22000,
                'rank_id' => $ranks->where('name', 'Bronze')->first()->id,
                'profile_complete' => true,
                'isActive' => true,
                'registrationKeyId' => null,
            ],

            // Utilisateur inactif
            [
                'name' => 'Inactive User',
                'lastname' => 'Inactive',
                'firstname' => 'User',
                'nickname' => 'inactive_old',
                'email' => 'inactive@breitling.com',
                'email_verified_at' => now()->subMonths(6),
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 5000,
                'rank_id' => $ranks->where('name', 'Bronze')->first()->id,
                'profile_complete' => false,
                'isActive' => false, // Utilisateur désactivé
                'registrationKeyId' => null,
            ],

            // Utilisateur sans email vérifié
            [
                'name' => 'Pending User',
                'lastname' => 'Pending',
                'firstname' => 'Email',
                'nickname' => 'pending_email',
                'email' => 'pending@breitling.com',
                'email_verified_at' => null, // Email non vérifié
                'password' => Hash::make('password'),
                'site_web' => null,
                'points' => 0,
                'rank_id' => $ranks->where('name', 'Bronze')->first()->id,
                'profile_complete' => false,
                'isActive' => true,
                'registrationKeyId' => null,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
