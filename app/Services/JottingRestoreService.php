<?php

namespace App\Service;

class JottingRestoreService
{
    public function restore(Jotting $jotting, JottingVersion $version, User $actor)
    {
        DB::transaction(function () use ($jotting, $version, $actor) {

            $snapshot = $version->snapshot;

            // 1️⃣ Restore content
            $jotting->update([
                'content' => $snapshot['content'],
            ]);

            // 2️⃣ Replace attachments (clean slate)
            $jotting->attachments()->delete();

            foreach ($snapshot['attachments'] ?? [] as $attachment) {
                $jotting->attachments()->create([
                    'type' => $attachment['type'],
                    'path' => $attachment['path'],
                ]);
            }

            // 3️⃣ Create NEW version noting rollback
            app(JottingVersionService::class)
                ->create($jotting, $actor);
        });
    }
}
