<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attachment;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        // 100 attachments randomly linked to jottings
        Attachment::factory(100)->create();
    }
}
