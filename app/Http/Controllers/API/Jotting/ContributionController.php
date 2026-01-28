<?php

namespace App\Http\Controllers\API\Jotting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ContributionService;
use App\Models\Jotting;
use App\Models\Contribution;

class ContributionController extends Controller
{
    public function __construct(protected ContributionService $service) {}

    public function start(Jotting $jotting)
    {
        $contribution = $this->service->startContribution($jotting, auth()->user());
        return response()->json($contribution, 201);
    }

    public function addItem(Request $request, Contribution $contribution)
    {
        $data = $request->validate([
            'type' => 'required|in:text,voice,sketch',
            'content' => 'nullable|string',
            'file' => 'nullable|file|max:20480'
        ]);

        $item = $this->service->addItem($contribution, $data, auth()->user());
        return response()->json($item, 201);
    }

    public function submit(Contribution $contribution)
    {
        $this->service->submitContribution($contribution, auth()->user());
        return response()->json(['message' => 'Contribution submitted']);
    }

    public function review(Request $request, Contribution $contribution)
    {
        $data = $request->validate([
            'action' => 'required|in:accept,reject',
            'message' => 'nullable|string'
        ]);

        $status = $this->service->reviewContribution($contribution, $data, auth()->user());

        return response()->json(['status' => $status]);
    }
}
