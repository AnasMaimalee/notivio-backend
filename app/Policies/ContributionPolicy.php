<?php

namespace App\Policies;

use App\Models\CouContributionrse;
use App\Models\User;

class ContributionPolicy extends Policies

{
    public function review(User $user, Contribution $contribution)
    {
        return $user->id === $contribution->jotting->user_id
            || $user->role === 'superadmin';
    }
}


