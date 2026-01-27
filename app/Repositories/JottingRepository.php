<?php

namespace App\Repositories;

use App\Models\Jotting;

class JottingRepository
{
    public function listForUser($user)
    {
        if ($user->role === 'superadmin') {
            return Jotting::with(['course', 'user'])->latest()->get();
        }

        return Jotting::with(['course'])
            ->where('user_id', $user->id)
            ->orWhereHas('shares', fn ($q) =>
                $q->where('shared_with', $user->id)
            )
            ->latest()
            ->get();
    }

    public function find($id)
    {
        return Jotting::with(['versions', 'shares'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Jotting::create($data);
    }

    public function update(Jotting $jotting, array $data)
    {
        $jotting->update($data);
        return $jotting;
    }

    public function delete(Jotting $jotting)
    {
        return $jotting->delete();
    }
}
