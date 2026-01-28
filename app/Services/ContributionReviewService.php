<?php

namespace App\Services;

use App\Models\Contribution;
use App\Repositories\ContributionRepository;
use Illuminate\Support\Facades\Gate;

class ContributionReviewService
{
    public function __construct(
        protected ContributionRepository $repo
    ) {}

    public function accept(Contribution $contribution, $user)
    {
        Gate::authorize('review', $contribution);

        return $this->repo->accept($contribution);
    }

    public function reject(Contribution $contribution, $user)
    {
        Gate::authorize('review', $contribution);

        $this->repo->reject($contribution);
    }
}
