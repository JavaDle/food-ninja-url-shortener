<?php

namespace App\Filament\Plugins\CacheCleaner\Livewire;

use App\Filament\Plugins\CacheCleaner\Jobs\ClearCacheJob;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

class CacheClearButton extends Component
{
    public string $cache_count = '0 B';

    public function mount(): void
    {
        $this->cache_count = self::getCacheSize();
    }

    public function clearCache(): void
    {
        Cache::flush();

        Notification::make()
            ->success()
            ->title(trans('admin.cache_cleared'))
            ->send();

        // Обновим отображаемый размер кэша после очистки
        $this->cache_count = self::getCacheSize();

        ClearCacheJob::dispatchAfterResponse();

        if ($referer = request()->header('Referer')) {
            $this->redirect($referer);
        }
    }

    private function getCacheSize(): string
    {
        $driver = config('cache.default');
        $size = 0;

        try {
            match ($driver) {
                'file' => $size = 'framework/cache/data'
                        |> storage_path(...)
                        |> File(...)
                        |> (fn($x) => array_map(fn($f) => $f->getSize(), $x))
                        |> array_sum(...),
                'database' => $size = (int)DB::table(config('cache.stores.database.table', 'cache'))
                    ->sum(DB::raw('LENGTH(value)')),
                'redis' => $size = (int)(Redis::command('INFO', ['memory'])['used_memory'] ?? 0),
                default => $size = 0,
            };
        } catch (Throwable) {
            //
        }

        return self::formatSizeUnits($size);
    }

    private function formatSizeUnits(int|float $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function render(): View
    {
        return view('filament.plugins.cache.cache-clear-button');
    }
}
