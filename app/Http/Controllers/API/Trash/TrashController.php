<?php

namespace App\Http\Controllers\API\Trash;

use App\Http\Controllers\Controller;
use App\Services\TrashService;
use App\Models\{
    Course,
    Jotting,
    Attachment,
    Contribution,
    ContributionItem
};

class TrashController extends Controller
{
    protected array $models = [
        'course' => Course::class,
        'jotting' => Jotting::class,
        'attachment' => Attachment::class,
        'contribution' => Contribution::class,
        'contribution_item' => ContributionItem::class,
    ];

    public function __construct(
        protected TrashService $service
    ) {}

    public function index()
    {
        return response()->json(
            $this->service->list($this->models, auth('api')->user())
        );
    }

    public function restore(string $type, string $id)
    {
        $this->validateType($type);

        return response()->json([
            'message' => 'Restored successfully',
            'data' => $this->service->restore(
                $this->models[$type],
                $id,
                auth('api')->user()
            )
        ]);
    }

    public function forceDelete(string $type, string $id)
    {
        $this->validateType($type);

        $this->service->forceDelete(
            $this->models[$type],
            $id,
            auth('api')->user()
        );

        return response()->json([
            'message' => 'Permanently deleted'
        ]);
    }

    protected function validateType(string $type): void
    {
        abort_unless(isset($this->models[$type]), 404, 'Invalid trash type');
    }
}
