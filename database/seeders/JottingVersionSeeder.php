<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JottingVersion;

class JottingVersionSeeder extends Seeder
{
    public function run(): void
    {
        // 100 version snapshots
        JottingVersion::factory(100)->create();
    }
}
