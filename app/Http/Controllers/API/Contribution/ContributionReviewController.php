<?php

namespace App\Http\Controllers\Api\Contribution;

class ContributionReviewController extends Controller
{
    public function __construct(
        protected ContributionReviewService $service
    ) {}

    public function accept(Contribution $contribution)
    {
        return response()->json(
            $this->service->accept($contribution, request()->user())
        );
    }

    public function reject(Contribution $contribution)
    {
        $this->service->reject($contribution, request()->user());

        return response()->json(['message' => 'Contribution rejected']);
    }
}

