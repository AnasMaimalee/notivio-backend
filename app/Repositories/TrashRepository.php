<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Jotting;
use App\Models\Attachment;

class TrashRepository
{
    public function getTrashedCourses()
    {
        return Course::onlyTrashed()->with('user')->get();
    }

    public function getTrashedJottings($user)
    {
        if ($user->role === 'superadmin') {
            return Jotting::onlyTrashed()->with('user')->get();
        }

        return Jotting::onlyTrashed()
            ->where('user_id', $user->id)
            ->with('user')
            ->get();
    }

    public function getTrashedAttachments($user)
    {
        if ($user->role === 'superadmin') {
            return Attachment::onlyTrashed()->with('jotting')->get();
        }

        return Attachment::onlyTrashed()
            ->whereHas('jotting', fn($q) => $q->where('user_id', $user->id))
            ->with('jotting')
            ->get();
    }
}
