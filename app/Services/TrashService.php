<?php

namespace App\Services;

use App\Repositories\TrashRepository;

class TrashService
{
    public function __construct(protected TrashRepository $repo) {}

    public function fetchTrash($user)
    {
        $courses = $this->repo->getTrashedCourses();
        $jottings = $this->repo->getTrashedJottings($user);
        $attachments = $this->repo->getTrashedAttachments($user);

        $normalized = [];

        // Courses
        foreach ($courses as $course) {
            $normalized[] = [
                'id' => $course->id,
                'type' => 'course',
                'title' => $course->title,
                'deleted_at' => $course->deleted_at,
                'owner' => [
                    'id' => $course->user->id,
                    'name' => $course->user->name,
                ],
            ];
        }

        // Jottings
        foreach ($jottings as $jotting) {
            $normalized[] = [
                'id' => $jotting->id,
                'type' => 'jotting',
                'title' => $jotting->title,
                'deleted_at' => $jotting->deleted_at,
                'owner' => [
                    'id' => $jotting->user->id,
                    'name' => $jotting->user->name,
                ],
            ];
        }

        // Attachments
        foreach ($attachments as $attachment) {
            $normalized[] = [
                'id' => $attachment->id,
                'type' => 'attachment',
                'filename' => $attachment->filename,
                'deleted_at' => $attachment->deleted_at,
                'parent' => [
                    'type' => 'jotting',
                    'id' => $attachment->jotting->id,
                ],
            ];
        }

        // Sort by deleted_at descending
        usort($normalized, fn($a, $b) => strtotime($b['deleted_at']) <=> strtotime($a['deleted_at']));

        return $normalized;
    }
}
