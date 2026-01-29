<?php

namespace App\Http\Controllers\API\Jotting;

class JottingVersionController extends Controller
{
     public function restore(Jotting $jotting, int $version)
    {
        $this->authorize('restore', $jotting);

        $jottingVersion = app(JottingVersionRepository::class)
            ->findForJotting($jotting->id, $version);

        app(JottingRestoreService::class)
            ->restore($jotting, $jottingVersion, auth()->user());

        return response()->json([
            'message' => 'Jotting restored successfully'
        ]);
    }
}