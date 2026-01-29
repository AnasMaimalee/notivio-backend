<?php

namespace App\Service;

class ContributionApprovalService
{
    public function accept(Contribution $contribution, User $actor)
    {
        DB::transaction(function () use ($contribution, $actor) {

            $jotting = $contribution->jotting;

            // 1️⃣ Merge contribution items
            foreach ($contribution->items as $item) {

                match ($item->type) {
                    'text' => $this->mergeText($jotting, $item),
                    'voice' => $this->attachMedia($jotting, $item),
                    'sketch' => $this->attachMedia($jotting, $item),
                };
            }

            // 2️⃣ Mark accepted
            $contribution->update(['status' => 'accepted']);

            // 3️⃣ Create snapshot version
            app(JottingVersionService::class)
                ->create($jotting, $actor);
        });
    }

    protected function mergeText(Jotting $jotting, $item)
    {
        $jotting->update([
            'content' => $jotting->content . "\n" . $item->content
        ]);
    }

    protected function attachMedia(Jotting $jotting, $item)
    {
        $jotting->attachments()->create([
            'type' => $item->type,
            'path' => $item->content,
        ]);
    }
}
