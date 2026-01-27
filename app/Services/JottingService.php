<?php

namespace App\Services;

use App\Repositories\JottingRepository;
use App\Models\Jotting;
use Illuminate\Support\Str;

class JottingService
{
    public function __construct(
        protected JottingRepository $repo
    ) {}

    public function list($user)
    {
        return $this->repo->listForUser($user);
    }

    public function create($user, array $data)
    {
        return $this->repo->create([
            'id' => (string) Str::uuid(),
            'user_id' => $user->id,
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'content' => $data['content'] ?? null,
        ]);
    }

    public function update($user, Jotting $jotting, array $data)
    {
        // owner OR editor
        if ($jotting->user_id !== $user->id &&
            !$jotting->shares()
                ->where('shared_with', $user->id)
                ->where('permission', 'edit')
                ->exists()
        ) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->update($jotting, $data);
    }

    public function delete($user, Jotting $jotting)
    {
        if ($user->role !== 'superadmin' && $jotting->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->delete($jotting);
    }
}
