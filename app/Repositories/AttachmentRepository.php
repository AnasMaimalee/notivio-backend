<?php

namespace App\Repositories;

use App\Models\Attachment;

class AttachmentRepository
{
    public function create(array $data)
    {
        return Attachment::create($data);
    }

    public function listByJotting($jottingId)
    {
        return Attachment::where('jotting_id', $jottingId)->get();
    }

    public function find($id)
    {
        return Attachment::findOrFail($id);
    }

    public function delete(Attachment $attachment)
    {
        return $attachment->delete();
    }
}
