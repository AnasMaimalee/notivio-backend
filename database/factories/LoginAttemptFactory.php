<?php

namespace Database\Factories;

use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoginAttemptFactory extends Factory
{
    protected $model = LoginAttempt::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();

        return [
            'user_id' => $user ? $user->id : null,
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'successful' => $this->faker->boolean(80), // 80% chance success
            'created_at' => now()->subMinutes(rand(1, 1000)),
        ];
    }
}
