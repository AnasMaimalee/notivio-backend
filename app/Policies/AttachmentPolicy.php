<?php

namespace App\Policies;

use App\Models\Attachment;
use App\Models\User;

class AttachmentPolicy
{
    public function view(User $user, Attachment $attachment): bool
    {
        $jotting = $attachment->jotting;

        return
            $jotting->user_id === $user->id ||
            $jotting->shares()->where('user_id', $user->id)->exists();
    }
}
