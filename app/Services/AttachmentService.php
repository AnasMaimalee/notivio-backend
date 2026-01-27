<?php

namespace App\Services;

use App\Models\Jotting;
use App\Models\Attachment;
use App\Repositories\AttachmentRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{
    public function __construct(protected AttachmentRepository $repo) {}

    public function store(Jotting $jotting, $file)
    {
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $type = match(strtolower($extension)) {
            'jpg','jpeg','png','gif','bmp' => 'image',
            'pdf' => 'pdf',
            'mp3','wav','m4a' => 'audio',
            default => 'file',
        };

        $path = $file->store("jottings/{$jotting->id}");

        return $this->repo->create([
            'id' => (string) Str::uuid(),
            'jotting_id' => $jotting->id,
            'filename' => $filename,
            'path' => $path,
            'type' => $type,
        ]);
    }

    public function list(Jotting $jotting)
    {
        return $this->repo->listByJotting($jotting->id);
    }

    public function delete(Attachment $attachment)
    {
        Storage::delete($attachment->path);
        return $this->repo->delete($attachment);
    }
}
