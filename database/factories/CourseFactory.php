<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'user_id' => 'ceae0c73-2e42-47f8-ab50-78fc444fb6f1',
        ];
    }
}
