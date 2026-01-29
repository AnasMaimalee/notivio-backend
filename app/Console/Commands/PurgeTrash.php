<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PurgeTrash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-trash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = [
            Course::class,
            Jotting::class,
            Attachment::class,
            Contribution::class,
            ContributionItem::class,
        ];

        foreach ($models as $model) {
            $model::onlyTrashed()
                ->where('deleted_at', '<', now()->subDays(30))
                ->forceDelete();
        }
    }

}
