<?php

namespace App\Services;

use App\Repositories\ContributionRepository;
use App\Models\Contribution;
use Illuminate\Support\Facades\Gate;

class ContributionService
{
    public function __construct(protected ContributionRepository $repo) {}

    public function startContribution($jotting, $user)
    {
        abort_unless(
            $jotting->shares()->where('user_id', $user->id)->exists(),
            403,
            'Not shared with you'
        );

        return $this->repo->createContribution($jotting->id, $user->id);
    }

    public function addItem(Contribution $contribution, array $data, $user)
    {
        abort_if($contribution->status !== 'pending', 403);
        abort_unless($contribution->contributor_id === $user->id, 403);

        if (!empty($data['file'])) {
            $data['content'] = $data['file']->store('contributions', 'public');
        }

        return $this->repo->addItem($contribution, $data);
    }

    public function submitContribution(Contribution $contribution, $user)
    {
        abort_unless($contribution->contributor_id === $user->id, 403);

        return $this->repo->updateContribution($contribution, [
            'status' => 'submitted'
        ]);
    }

    public function reviewContribution(Contribution $contribution, array $data, $user)
    {
        abort_unless($contribution->jotting->user_id === $user->id, 403);

        if ($data['action'] === 'accept') {
            $this->mergeContribution($contribution);
            $status = 'accepted';
        } else {
            $status = 'rejected';
        }

        $this->repo->updateContribution($contribution, [
            'status' => $status,
            'message' => $data['message'] ?? null,
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
        ]);

        return $status;
    }

    protected function mergeContribution(Contribution $contribution)
    {
        $jotting = $contribution->jotting;

        foreach ($contribution->items as $item) {
            if ($item->type === 'text') {
                $jotting->content .= "\n\n" . $item->content;
            }

            if (in_array($item->type, ['voice', 'sketch'])) {
                $jotting->attachments()->create([
                    'path' => $item->content,
                    'type' => $item->type,
                ]);
            }
        }

        $jotting->save();
    }
}
