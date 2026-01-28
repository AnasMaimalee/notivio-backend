<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
   public function restore(User $user, Course $course)
    {
        return $user->id === $course->user_id
            || $user->role === 'superadmin';
    }
}
