<?php

namespace App\Filament\Plugins\CacheCleaner\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class ClearCacheJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $commands = [
            'route:trans:clear',
            'filament:optimize-clear',
            'optimize:clear',
            'filament:optimize',
            'optimize',
            'route:trans:cache',
        ];

        foreach ($commands as $command) {
            try {
                Artisan::call($command);
            } catch (Throwable $e) {
                logger()->error("Artisan command failed: {$command}", [
                    'message' => $e->getMessage(),
                ]);

                continue;
            }
        }
    }
}
