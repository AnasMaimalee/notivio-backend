<?php

namespace Database\Factories;

use App\Models\Contribution;
use App\Models\Jotting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

$path = Storage::disk('public')->putFile('voice', new File(resource_path('demo/voice.mp3')));
$path = Storage::disk('public')->putFile('sketch', new File(resource_path('demo/sketch.webp')));

class ContributionFactory extends Factory
{
    protected $model = Contribution::class;

    public function definition()
    {
        $jotting = Jotting::inRandomOrder()->first();
        $user = $jotting?->shares()->inRandomOrder()->first()?->user ?: User::inRandomOrder()->first();

        return [
            'jotting_id' => $jotting->id,
            'contributor_id' => $user->id,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
            'message' => $this->faker->sentence(),
        ];
    }

}
