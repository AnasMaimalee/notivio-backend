<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class TrashRepository
{
    public function getTrashed(string $modelClass)
    {
        return $modelClass::onlyTrashed()->with(['user'])->get();
    }

    public function findTrashed(string $modelClass, string $id): Model
    {
        return $modelClass::onlyTrashed()->findOrFail($id);
    }

    public function restore(Model $model): Model
    {
        $model->restore();
        return $model->fresh();
    }

    public function forceDelete(Model $model): void
    {
        $model->forceDelete();
    }
}
