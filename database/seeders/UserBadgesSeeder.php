<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserBadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $badges = Badge::all();

        // Admin - Tous les badges
        $admin = $users->where('email', 'admin@breitling.com')->first();
        foreach ($badges as $badge) {
            $admin->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(30, 90)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Sarah Johnson (Diamond) - Expert aviation + autres spécialisations
        $sarah = $users->where('email', 'sarah.johnson@breitling.com')->first();
        $sarahBadges = [
            'Aviation Expert',
            'Navitimer Specialist',
            'Heritage Specialist',
            'Professional Master',
            'Chronoliner Expert',
            'Certification Master',
            'Innovation Pioneer',
            'Breitling Ambassador'
        ];
        foreach ($sarahBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $sarah->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(15, 60)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Marcus Weber (Diamond) - Expert chronographes et mouvements
        $marcus = $users->where('email', 'marcus.weber@breitling.com')->first();
        $marcusBadges = [
            'Chronomètre Master',
            'Movement Specialist',
            'Professional Master',
            'Heritage Specialist',
            'Craftsmanship Expert',
            'Certification Master',
            'Limited Edition Collector'
        ];
        foreach ($marcusBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $marcus->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(20, 80)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Elena Rodriguez (Platinum) - Expert plongée
        $elena = $users->where('email', 'elena.rodriguez@breitling.com')->first();
        $elenaBadges = [
            'Superocean Expert',
            'Professional Master',
            'Heritage Specialist',
            'Innovation Pioneer',
            'Certification Master'
        ];
        foreach ($elenaBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $elena->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(10, 50)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Thomas Chen (Platinum) - Tech et innovation
        $thomas = $users->where('email', 'thomas.chen@breitling.com')->first();
        $thomasBadges = [
            'Innovation Pioneer',
            'Movement Specialist',
            'Professional Master',
            'Certification Master',
            'Heritage Specialist'
        ];
        foreach ($thomasBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $thomas->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(15, 45)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Marie Dubois (Gold) - Collectionneuse
        $marie = $users->where('email', 'marie.dubois@breitling.com')->first();
        $marieBadges = [
            'Limited Edition Collector',
            'Premier Connoisseur',
            'Heritage Specialist',
            'Craftsmanship Expert'
        ];
        foreach ($marieBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $marie->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(5, 35)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // David Thompson (Gold) - Vendeur expérimenté
        $david = $users->where('email', 'david.thompson@breitling.com')->first();
        $davidBadges = [
            'Professional Master',
            'Heritage Specialist',
            'Breitling Ambassador'
        ];
        foreach ($davidBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $david->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(10, 40)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Anna Kowalski (Gold) - Spécialiste patrimoine
        $anna = $users->where('email', 'anna.kowalski@breitling.com')->first();
        $annaBadges = [
            'Heritage Specialist',
            'Craftsmanship Expert',
            'Certification Master'
        ];
        foreach ($annaBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $anna->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(8, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // James Miller (Silver) - Débutant avec quelques badges
        $james = $users->where('email', 'james.miller@breitling.com')->first();
        $jamesBadges = [
            'Heritage Specialist',
            'Professional Master'
        ];
        foreach ($jamesBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $james->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(3, 20)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Lisa Anderson (Silver) - Boutique avec badges de base
        $lisa = $users->where('email', 'lisa.anderson@breitling.com')->first();
        $lisaBadges = [
            'Heritage Specialist',
            'Premier Connoisseur'
        ];
        foreach ($lisaBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $lisa->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(5, 25)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Roberto Silva (Silver) - Un seul badge
        $roberto = $users->where('email', 'roberto.silva@breitling.com')->first();
        $robertoBadges = ['Heritage Specialist'];
        foreach ($robertoBadges as $badgeName) {
            $badge = $badges->where('name', $badgeName)->first();
            $roberto->badges()->attach($badge->id, [
                'date_obtained' => Carbon::now()->subDays(rand(1, 15)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Sophie Martin (Bronze) - Badge de base récent
        $sophie = $users->where('email', 'sophie.martin@breitling.com')->first();
        $badge = $badges->where('name', 'Heritage Specialist')->first();
        $sophie->badges()->attach($badge->id, [
            'date_obtained' => Carbon::now()->subDays(3),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Yuki Tanaka (Bronze) - Badge récent
        $yuki = $users->where('email', 'yuki.tanaka@breitling.com')->first();
        $badge = $badges->where('name', 'Heritage Specialist')->first();
        $yuki->badges()->attach($badge->id, [
            'date_obtained' => Carbon::now()->subDays(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Michael Brown (Bronze) et les autres utilisateurs n'ont pas encore de badges
    }
}
