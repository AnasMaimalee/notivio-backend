<?php

namespace App\Http\Controllers\API\Jotting;

use App\Http\Controllers\Controller;
use App\Models\Jotting;
use App\Services\JottingService;
use App\Services\JottingVersionService;
use Illuminate\Http\Request;

class JottingController extends Controller
{
    protected JottingService $service;
    protected JottingVersionService $versionService;

    public function __construct(JottingService $service, JottingVersionService $versionService)
    {
        $this->service = $service;
        $this->versionService = $versionService;
    }

    /**
     * List all jottings visible to the user (including shared).
     */
    public function index()
    {
        $user = auth('api')->user();
        return response()->json($this->service->list($user));
    }

    /**
     * Create a new jotting and save first version.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|uuid|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $user = auth('api')->user();

        // Create jotting via service
        $jotting = $this->service->create($user, $data);

        // Save first version
        $this->versionService->snapshot($jotting, $user);

        return response()->json($jotting, 201);
    }

    /**
     * Show a jotting with versions and shares.
     */
    public function show(Jotting $jotting)
    {
        return response()->json($jotting->load(['versions', 'shares']));
    }

    /**
     * Update jotting and create a new version.
     */
    public function update(Request $request, Jotting $jotting)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'nullable|string',
        ]);

        $user = auth('api')->user();

        // Update via service (handles permissions)
        $jotting = $this->service->update($user, $jotting, $data);

        // Create a new version snapshot
        $this->versionService->snapshot($jotting, $user);

        return response()->json($jotting);
    }

    /**
     * Delete jotting (superadmin or owner).
     */
    public function destroy(Jotting $jotting)
    {
        $this->service->delete(auth('api')->user(), $jotting);

        return response()->json(['message' => 'Deleted']);
    }
    
    public function versions(Jotting $jotting)
    {
        $this->authorize('view', $jotting);

        return response()->json(
            $jotting->versions()->latest()->get()
        );
    }

    public function revertVersion(Jotting $jotting, int $version)
    {
        return response()->json(
            app(JottingVersionService::class)
                ->restore($jotting, $version, auth('api')->user())
        );
    }

}