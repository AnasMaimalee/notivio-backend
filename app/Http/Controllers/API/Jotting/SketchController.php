<?php

namespace App\Http\Controllers;

use App\Models\Jotting;
use App\Services\SketchService;
use Illuminate\Http\Request;

class SketchController extends Controller
{
    public function __construct(
        protected SketchService $service
    ) {}

    public function store(Request $request, Jotting $jotting)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.canvas' => 'required|array',
            'data.strokes' => 'required|array',
        ]);

        return response()->json(
            $this->service->create($request->user(), $jotting, $validated['data']),
            201
        );
    }

    public function index(Jotting $jotting)
    {
        return response()->json(
            $this->service->listForJotting($jotting)
        );
    }
}
