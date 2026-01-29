<?php

namespace App\Services;

use App\Repositories\UserThemeRepository;
use App\Models\UserTheme;

class UserThemeService
{
    public function __construct(protected UserThemeRepository $repo) {}

    public function setUserTheme(string $userId, array $data): UserTheme
    {
        return $this->repo->createOrUpdate($userId, $data);
    }

    public function getUserTheme(string $userId): ?UserTheme
    {
        return $this->repo->getByUser($userId);
    }

    public function listThemeOptions(): array
    {
        return $this->repo->getAllOptions();
    }
}
