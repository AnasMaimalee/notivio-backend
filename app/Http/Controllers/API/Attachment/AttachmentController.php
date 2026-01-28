<?php

namespace App\Http\Controllers\API\Attachment;

use App\Http\Controllers\Controller;
use App\Models\Jotting;
use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttachmentController extends Controller
{
    protected AttachmentService $service;

    public function __construct(AttachmentService $service)
    {
        $this->service = $service;
    }

    public function index(Jotting $jotting)
    {
        return response()->json($this->service->list($jotting));
    }

    public function store(Request $request, Jotting $jotting)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $attachment = $this->service->store($jotting, $request->file('file'));

        return response()->json($attachment, 201);
    }

    public function show(Jotting $jotting, Attachment $attachment)
    {
        return response()->file(storage_path("app/{$attachment->path}"));
    }

    public function destroy(Jotting $jotting, Attachment $attachment)
    {
        $this->service->delete($attachment);

        return response()->json(['message' => 'Attachment deleted']);
    }

    public function download(Attachment $attachment)
    {
        $this->authorize('view', $attachment);


        return response()->download(
            storage_path('app/' . $attachment->path),
            $attachment->original_name,
            [
                'Content-Type' => $attachment->mime_type,
            ]
        );
    }
    protected function canAccessAttachment($user, $attachment): bool
    {
        $jotting = $attachment->jotting;

        return
            $jotting->user_id === $user->id ||
            $jotting->shares()->where('user_id', $user->id)->exists();
    }


    public function stream(Attachment $attachment)
    {
        $this->authorize('view', $attachment);

        $path = storage_path('app/' . $attachment->path);

        if (!file_exists($path)) {
            abort(404, 'Audio not found');
        }

        return response()->stream(function () use ($path) {
            $stream = fopen($path, 'rb');
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $attachment->mime_type,
            'Accept-Ranges' => 'bytes',
            'Content-Length' => filesize($path),
        ]);
    }

}
