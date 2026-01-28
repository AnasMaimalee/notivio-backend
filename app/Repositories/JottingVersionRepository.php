<?php

namespace App\Repositories;

use App\Models\JottingVersion;

class JottingVersionRepository
{
    public function create(array $data)
    {
        return JottingVersion::create($data);
    }

    public function history($jottingId)
    {
        return JottingVersion::where('jotting_id', $jottingId)
            ->with('user:id,name')
            ->orderByDesc('version')
            ->get();
    }

   public function find(Jotting $jotting, int $version)
    {
        return $jotting->versions()
            ->where('version', $version)
            ->firstOrFail();
    }
}
