<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contribution;
use App\Models\Jotting;
use App\Models\User;

class ContributionItemSeeder extends Seeder
{
    public function run(): void
    {
        // Loop through some jottings
        Jotting::all()->each(function ($jotting) {
            
            // Create 1-5 contributions per jotting
            for ($i = 0; $i < rand(1, 5); $i++) {
                $contributor = $jotting->shares()->inRandomOrder()->first()?->user ?? User::inRandomOrder()->first();

                Contribution::factory()->create([
                    'jotting_id' => $jotting->id,
                    'contributor_id' => $contributor->id,
                ]);
            }
        });
    }
}
