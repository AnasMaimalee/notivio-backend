<?php

namespace Database\Factories;

use App\Models\ContributionItem;
use App\Models\Contribution;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContributionItemFactory extends Factory
{
    protected $model = ContributionItem::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['text', 'voice', 'sketch']);

        $content = match($type) {
            'text' => $this->faker->paragraph(),
            'voice' => 'voice/voice' . rand(1,3) . '.mp3',
            'sketch' => 'sketch/sketch' . rand(1,3) . '.png',
        };

        return [
            'contribution_id' => Contribution::factory(),
            'type' => $type,
            'content' => $content,
        ];
    }
}
