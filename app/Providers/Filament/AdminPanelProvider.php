<?php

namespace App\Providers\Filament;

use App\Filament\Plugins\CacheCleaner\CacheClearPlugin;
use App\Filament\Plugins\LocaleSwitcher\LocaleSwitcherPlugin;
use App\Filament\Widgets\LinkStatsOverview;
use App\Filament\Widgets\TopLinksChart;
use App\Filament\Widgets\VisitsByCountryChart;
use App\Filament\Widgets\VisitsOverTimeChart;
use App\Helpers\GlobalHelpers;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Platform;
use Filament\Support\Enums\Width;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('cabinet')
            ->path('cabinet')
            ->login()
            ->profile()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->emailChangeVerification()
            ->spa()
            ->topbar()
            ->topNavigation(false)
            ->sidebarCollapsibleOnDesktop()
            ->unsavedChangesAlerts()
            ->databaseTransactions()
            ->databaseNotifications()
            ->lazyLoadedDatabaseNotifications()
            ->darkMode()
            ->maxContentWidth(Width::Full)
            ->brandLogo(GlobalHelpers::brandLogo())
            ->darkModeBrandLogo(GlobalHelpers::brandLogo())
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                LinkStatsOverview::class,
                VisitsOverTimeChart::class,
                TopLinksChart::class,
                VisitsByCountryChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->globalSearchKeyBindings(['command+k', 'ctrl+f'])->globalSearchFieldSuffix(fn (): ?string => match (Platform::detect()) {
                Platform::Windows, Platform::Linux => 'CTRL+F',
                Platform::Mac => '⌘K',
                default => null,
            })
            ->plugins([
                CacheClearPlugin::make(),
                LocaleSwitcherPlugin::make()
            ])
            ->font('Unbounded', provider: GoogleFontProvider::class)
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
