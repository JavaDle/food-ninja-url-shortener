<?php

namespace App\Filament\Plugins\CacheCleaner;

use App\Filament\Plugins\CacheCleaner\Livewire\CacheClearButton;
use Filament\Contracts\Plugin;
use Filament\Notifications\Notification;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\On;
use Livewire\Livewire;

class CacheClearPlugin implements Plugin
{
    protected string $renderHook = PanelsRenderHook::USER_MENU_PROFILE_AFTER;

    public function getId(): string
    {
        return 'tx-cache-clear';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        Livewire::component('cache-clear-button', CacheClearButton::class);

        $panel->renderHook(
            name: $this->renderHook,
            hook: fn () => Blade::render('<livewire:cache-clear-button />')
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    #[On('clear-cache')]
    public function clearCache(): void
    {
        Artisan::call('route:trans:clear');
        Artisan::call('optimize:clear');
        Artisan::call('optimize');
        Artisan::call('route:trans:cache');

        Notification::make()
            ->success()
            ->title(__('alisa-core::ui.cache_cleared'))
            ->send();
    }
}
