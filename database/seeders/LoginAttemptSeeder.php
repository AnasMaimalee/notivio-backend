<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoginAttempt;

class LoginAttemptSeeder extends Seeder
{
    public function run(): void
    {
        // 100 attachments randomly linked to jottings
        LoginAttempt::factory(100)->create();
    }
}