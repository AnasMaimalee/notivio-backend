<?php

namespace App\Services;

use App\Repositories\SketchRepository;
use App\Models\Jotting;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class SketchService
{
    public function __construct(
        protected SketchRepository $repo
    ) {}

    public function create(User $user, Jotting $jotting, array $data)
    {
        Gate::authorize('update', $jotting);

        return $this->repo->create([
            'jotting_id' => $jotting->id,
            'user_id' => $user->id,
            'data' => $data,
        ]);
    }

    public function listForJotting(Jotting $jotting)
    {
        Gate::authorize('view', $jotting);

        return $this->repo->getByJotting($jotting->id);
    }
}
