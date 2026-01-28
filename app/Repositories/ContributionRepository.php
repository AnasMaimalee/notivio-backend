<?php

namespace App\Repositories;

use App\Models\Contribution;
use App\Models\ContributionItem;

class ContributionRepository
{
    public function createContribution(int $jottingId, int $userId): Contribution
    {
        return Contribution::create([
            'jotting_id' => $jottingId,
            'contributor_id' => $userId,
            'status' => 'pending',
        ]);
    }

    public function addItem(Contribution $contribution, array $data): ContributionItem
    {
        return ContributionItem::create([
            'contribution_id' => $contribution->id,
            'type' => $data['type'],
            'content' => $data['content'] ?? null,
        ]);
    }

    public function restoreContribution(int $id): ?Contribution
    {
        return Contribution::withTrashed()->find($id);
    }

    public function updateContribution(Contribution $contribution, array $data): bool
    {
        return $contribution->update($data);
    }
}
