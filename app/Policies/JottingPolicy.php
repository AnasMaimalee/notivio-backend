<?php

namespace App\Policies;

use App\Models\Jotting;
use App\Models\User;

class JottingPolicy
{
   public function restore(User $user, Jotting $jotting)
    {
        return $user->id === $jotting->user_id
            || $user->role === 'superadmin';
    }
}
