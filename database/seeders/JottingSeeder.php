<?php

namespace Database\Seeders;

use App\Models\Jotting;
use App\Models\JottingVersion;
use App\Models\JottingShare;
use Illuminate\Database\Seeder;

class JottingSeeder extends Seeder
{
    public function run(): void
    {
        JottingShare::factory(50)->create();

        JottingVersion::factory(100)->create();
        JottingShare::factory(40)->create();
    }
}
