<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Jotting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

$path = Storage::disk('public')->putFile('voice', new File(resource_path('demo/voice.mp3')));
$path = Storage::disk('public')->putFile('sketch', new File(resource_path('demo/sketch.webp')));

class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition()
    {
        $types = ['image', 'pdf', 'audio'];
        $type = $this->faker->randomElement($types);

        $sourceFile = match($type) {
            'audio' => resource_path('demo/voice.mp3'),
            'image' => resource_path('demo/sketch.webp'),
            'pdf' => resource_path('demo/sample.pdf'),
        };

        $filename = $this->faker->word() . '.' . pathinfo($sourceFile, PATHINFO_EXTENSION);
        $path = Storage::disk('public')->putFileAs('attachments/' . $type, new File($sourceFile), $filename);

        return [
            'id' => Str::uuid(),
            'jotting_id' => Jotting::inRandomOrder()->first()->id,
            'type' => $type,
            'filename' => $filename,
            'path' => $path,
        ];
    }

}
