<?php

namespace App\Services;

class JottingSnapshotService
{
    public function make(Jotting $jotting): array
    {
        return [
            'content' => $jotting->content,
            'attachments' => $jotting->attachments->map(fn ($a) => [
                'id' => $a->id,
                'type' => $a->type,
                'path' => $a->path,
            ]),
            'sketches' => $jotting->sketches ?? [],
            'voices' => $jotting->voices ?? [],
        ];
    }
}
