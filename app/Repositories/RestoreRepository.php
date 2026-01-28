<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class RestoreRepository
{
    public function findTrashed(string $modelClass, string $id)
    {
        return $modelClass::withTrashed()->findOrFail($id);
    }

    public function restore($model)
    {
        $model->restore();
        return $model;
    }
}


