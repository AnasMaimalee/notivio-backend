<?php

namespace Database\Factories;

use App\Models\JottingVersion;
use App\Models\Jotting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JottingVersionFactory extends Factory
{
    protected $model = JottingVersion::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'jotting_id' => Jotting::inRandomOrder()->value('id'),
            'edited_by' => User::inRandomOrder()->value('id'),
            'content' => $this->faker->paragraph(),
            'version' => $this->faker->numberBetween(1, 5),
        ];
    }
}
