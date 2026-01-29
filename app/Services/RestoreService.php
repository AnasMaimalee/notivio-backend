<?php

namespace App\Services;

use App\Repositories\RestoreRepository;
use Illuminate\Support\Facades\Gate;

class RestoreService
{
    public function __construct(
        protected RestoreRepository $repo
    ) {}

    public function restore(string $modelClass, string $id, $user)
    {
        $model = $this->repo->findTrashed($modelClass, $id);

        // 🔥 FIX: bind user explicitly
        Gate::forUser($user)->authorize('restore', $model);

        $restored = $this->repo->restore($model);

        activity()
            ->performedOn($restored)
            ->causedBy($user)
            ->log('restored');

        return $restored;
    }

    public function undoRestore(string $modelClass, string $id, $user)
    {
        $model = $modelClass::findOrFail($id);

        Gate::forUser($user)->authorize('restore', $model);

        $log = activity()
            ->causedBy($user)
            ->performedOn($model)
            ->latest()
            ->first();

        abort_if(
            !$log || now()->greaterThan($log->undo_until),
            403,
            'Undo window expired'
        );

        $model->delete(); // soft delete again

        return $model;
    }

    

}

