<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contribution;
use App\Models\ContributionItem;

class ContributionSeeder extends Seeder
{
    public function run(): void
    {
        // 30 contributions
        Contribution::factory(30)->create()->each(function ($contribution) {
            // Each contribution gets 1-3 items
            ContributionItem::factory(rand(1,3))->create([
                'contribution_id' => $contribution->id,
            ]);
        });
    }
}
