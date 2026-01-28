<?php

namespace App\Repositories;

use App\Models\Sketch;
use Illuminate\Support\Str;

class SketchRepository
{
    public function create(array $data): Sketch
    {
        return Sketch::create([
            'id' => Str::uuid(),
            ...$data,
        ]);
    }

    public function find(string $id): Sketch
    {
        return Sketch::findOrFail($id);
    }

    public function getByJotting(string $jottingId)
    {
        return Sketch::where('jotting_id', $jottingId)->latest()->get();
    }
}
