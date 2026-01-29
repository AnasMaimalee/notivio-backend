<?php

namespace App\Services;

use App\Repositories\TrashRepository;
use Illuminate\Support\Facades\Gate;

class TrashService
{
    public function __construct(
        protected TrashRepository $repo
    ) {}

    public function list(array $models, $user): array
    {
        $items = [];

        foreach ($models as $type => $modelClass) {
            foreach ($this->repo->getTrashed($modelClass) as $model) {
                if (Gate::forUser($user)->allows('restore', $model)) {
                    $items[] = [
                        'id' => $model->id,
                        'type' => $type,
                        'label' => $model->title ?? $model->filename ?? 'Item',
                        'deleted_at' => $model->deleted_at,
                    ];
                }
            }
        }

        usort($items, fn ($a, $b) =>
            strtotime($b['deleted_at']) <=> strtotime($a['deleted_at'])
        );

        return $items;
    }

    public function restore(string $modelClass, string $id, $user)
    {
        $model = $this->repo->findTrashed($modelClass, $id);

        Gate::forUser($user)->authorize('restore', $model);

        return $this->repo->restore($model);
    }

    public function forceDelete(string $modelClass, string $id, $user): void
    {
        $model = $this->repo->findTrashed($modelClass, $id);

        Gate::forUser($user)->authorize('restore', $model);

        $this->repo->forceDelete($model);
    }

    public function trashStats()
    {
        return [
            'courses' => Course::onlyTrashed()->count(),
            'jottings' => Jotting::onlyTrashed()->count(),
            'attachments' => Attachment::onlyTrashed()->count(),
            'contributions' => Contribution::onlyTrashed()->count(),
        ];
    }
}
