<?php

namespace App\Services;

use App\Models\Jotting;
use App\Models\JottingVersion;
use Illuminate\Support\Str;

class JottingVersionService
{
    /**
     * Create a new version snapshot of a jotting
     */
    public function snapshot(Jotting $jotting, $user)
    {
        $lastVersion = JottingVersion::where('jotting_id', $jotting->id)->max('version') ?? 0;

        return JottingVersion::create([
            'id' => Str::uuid(),
            'jotting_id' => $jotting->id,
            'edited_by' => $user->id,
            'content' => $jotting->content,
            'version' => $lastVersion + 1,
        ]);
    }

    /**
     * Get all versions for a jotting
     */
    public function allVersions(Jotting $jotting)
    {
        return JottingVersion::where('jotting_id', $jotting->id)
                             ->with('editor')
                             ->orderBy('version', 'desc')
                             ->get();
    }

    /**
     * Revert jotting to a previous version
     */
    public function revert(Jotting $jotting, JottingVersion $version)
    {
        $jotting->update(['content' => $version->content]);

        // Create a new snapshot for the revert action
        return $this->snapshot($jotting, auth('api')->user());
    }

    public function restore(Jotting $jotting, int $version, User $user)
    {
        Gate::forUser($user)->authorize('restore', $jotting);

        $versionData = $this->repo->find($jotting, $version);

        // overwrite content
        $jotting->update([
            'content' => $versionData->content,
        ]);

        // snapshot again (important!)
        $this->snapshot($jotting, $user);

        return $jotting;
    }
}
