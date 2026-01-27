<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jotting;
use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;

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
}
