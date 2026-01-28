<?php

namespace App\Http\Controllers\API\Restore;

use App\Http\Controllers\Controller;
use App\Services\RestoreService;
use App\Models\Course;
use App\Models\Jotting;
use App\Models\Attachment;

class RestoreController extends Controller
{
    public function __construct(
        protected RestoreService $service
    ) {}

    public function restoreCourse(string $id)
    {
        return response()->json([
            'message' => 'Jotting Restored Successfully',
            'data' => $this->service->restore(Course::class, $id, auth('api')->user())
        ]);
    }

    public function restoreJotting(string $id)
    {
        return response()->json([
            'message' => 'Jotting Restored Successfully',
            'data' => $this->service->restore(Jotting::class, $id, auth('api')->user())
        ]);
    }

    public function restoreAttachment(string $id)
    {
        return response()->json([
            'message' => 'Attachment Restored Successfully',
            'data' => $this->service->restore(Attachment::class, $id, auth('api')->user())
        ]);
    }
}
