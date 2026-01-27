<?php

namespace App\Http\Controllers\API\Jotting;

use App\Http\Controllers\Controller;
use App\Models\Jotting;
use App\Services\JottingService;
use Illuminate\Http\Request;

class JottingController extends Controller
{
    public function __construct(
        protected JottingService $service
    ) {}

    public function index()
    {
        return response()->json(
            $this->service->list(auth('api')->user())
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|uuid|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        return response()->json(
            $this->service->create(auth('api')->user(), $data),
            201
        );
    }

    public function show(Jotting $jotting)
    {
        return response()->json($jotting->load(['versions', 'shares']));
    }

    public function update(Request $request, Jotting $jotting)
    {
        $data = $request->only(['title', 'content']);

        return response()->json(
            $this->service->update(auth('api')->user(), $jotting, $data)
        );
    }

    public function destroy(Jotting $jotting)
    {
        $this->service->delete(auth('api')->user(), $jotting);

        return response()->json(['message' => 'Deleted']);
    }
}
