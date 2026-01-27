<?php

namespace Database\Factories;

use App\Models\Jotting;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JottingShareFactory extends Factory
{
    protected $model = Jotting::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'course_id' => Course::inRandomOrder()->value('id'),
            'user_id' =>'ceae0c73-2e42-47f8-ab50-78fc444fb6f1',
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraph(4),
            'voice_path' => null,
            'sketch_data' => null,
        ];
    }
}
