<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        User::create([
            'id' => '995deeb0-15c1-4f01-bdf7-1dcfdee2eb26',
            'name' => 'Notivio Super Admin',
            'email' => 'admin@notivio.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

         User::create([
            'id' => 'ceae0c73-2e42-47f8-ab50-78fc444fb6f1',
            'name' => 'Notivio User',
            'email' => 'anas@notivio.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Normal users
        User::factory(10)->create();
    }
}
