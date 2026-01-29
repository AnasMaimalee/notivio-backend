<?php

namespace App\Http\Controllers\Contribution;

class ContributionController extends Controller
{
    public function accept(Contribution $contribution)
    {
        $this->authorize('accept', $contribution);

        app(ContributionApprovalService::class)
            ->accept($contribution, auth()->user());

        return response()->json(['status' => 'accepted']);
    }
}