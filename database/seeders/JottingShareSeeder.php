<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JottingShare;

class JottingShareSeeder extends Seeder
{
    public function run(): void
    {
        // 50 shared jottings
        JottingShare::factory(50)->create();
    }
}
