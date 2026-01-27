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
            'id' => (string) Str::uuid(),
            'name' => 'Notivio Super Admin',
            'email' => 'admin@notivio.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

         User::create([
            'id' => Str::uuid(),
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
