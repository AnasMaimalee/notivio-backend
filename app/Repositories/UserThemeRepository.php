<?php

namespace App\Repositories;

use App\Models\UserTheme;

class UserThemeRepository
{
    public function createOrUpdate(string $userId, array $data): UserTheme
    {
        return UserTheme::updateOrCreate(
            ['user_id' => $userId],
            [
                'primary_color' => $data['primary_color'],
                'secondary_color' => $data['secondary_color'],
            ]
        );
    }

    public function getByUser(string $userId): ?UserTheme
    {
        return UserTheme::where('user_id', $userId)->first();
    }

    public function getAllOptions(): array
    {
        // Optional: predefined color options
        return [
            ['name' => 'Violet Emerald', 'primary' => '#6366F1', 'secondary' => '#10B981'],
            ['name' => 'Sunset Orange', 'primary' => '#F97316', 'secondary' => '#FBBF24'],
            ['name' => 'Ocean Blue', 'primary' => '#3B82F6', 'secondary' => '#06B6D4'],
            ['name' => 'Rose Pink', 'primary' => '#EC4899', 'secondary' => '#F472B6'],
        ];
    }
}
