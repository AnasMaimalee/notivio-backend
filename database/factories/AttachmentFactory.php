<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Jotting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition()
    {
        $types = ['image', 'pdf', 'audio'];

        return [
            'id' => Str::uuid(),
            'jotting_id' => Jotting::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement($types),
            'filename' => $this->faker->word() . '.' . $this->faker->fileExtension(),
            'path' => 'attachments/' . $this->faker->word() . '/' . $this->faker->word() . '.' . $this->faker->fileExtension(),
        ];
    }
}
