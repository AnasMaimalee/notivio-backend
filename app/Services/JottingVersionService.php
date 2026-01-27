<?php

namespace App\Services;

use App\Repositories\JottingVersionRepository;
use Illuminate\Support\Str;

class JottingVersionService
{
    public function __construct(
        protected JottingVersionRepository $repo
    ) {}

    public function snapshot($jotting, $user)
    {
        $latest = $jotting->versions()->max('version') ?? 0;

        return $this->repo->create([
            'id' => (string) Str::uuid(),
            'jotting_id' => $jotting->id,
            'user_id' => $user->id,
            'content' => $jotting->content,
            'version' => $latest + 1,
        ]);
    }

    public function history($jotting)
    {
        return $this->repo->history($jotting->id);
    }

    public function restore($jotting, $version)
    {
        $jotting->update([
            'content' => $version->content,
        ]);

        return $jotting;
    }
}
