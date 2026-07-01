<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Link;
use App\Models\User;
use App\Models\Visit;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class LinkStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '30s';

    protected static ?int $sort = 1;

    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $totalLinks = Link::query()->count();
        $activeLinks = Link::query()
            ->where('is_active', true)
            ->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->count();

        $totalClicks = (int) Link::query()->sum('clicks');

        $visitsToday = Visit::query()->whereDate('visited_at', today())->count();
        $visitsYesterday = Visit::query()->whereDate('visited_at', today()->subDay())->count();

        $visitsTrend = $this->clicksTrend();

        return [
            Stat::make(trans('admin.total_links'), number_format($totalLinks))
                ->description(trans('admin.active_links_count', ['count' => $activeLinks]))
                ->descriptionIcon(Heroicon::Link)
                ->color('primary'),

            Stat::make(trans('admin.total_visits'), number_format($totalClicks))
                ->description(trans('admin.across_all_links'))
                ->descriptionIcon(Heroicon::CursorArrowRays)
                ->chart($visitsTrend)
                ->color('success'),

            Stat::make(trans('admin.visits_today'), number_format($visitsToday))
                ->description($this->comparisonLabel($visitsToday, $visitsYesterday))
                ->descriptionIcon($visitsToday >= $visitsYesterday ? Heroicon::ArrowTrendingUp : Heroicon::ArrowTrendingDown)
                ->color($visitsToday >= $visitsYesterday ? 'success' : 'danger'),

            Stat::make(trans('admin.users'), number_format(User::query()->count()))
                ->description(trans('admin.registered_in_system'))
                ->descriptionIcon(Heroicon::Users)
                ->color('gray'),
        ];
    }

    /**
     * Количество переходов за каждый из последних 7 дней — для мини-графика в карточке.
     *
     * @return array<int, int>
     */
    private function clicksTrend(): array
    {
        $days = collect(range(6, 0))->map(fn (int $offset) => Carbon::today()->subDays($offset));

        return $days
            ->map(fn (Carbon $day) => Visit::query()->whereDate('visited_at', $day)->count())
            ->all();
    }

    private function comparisonLabel(int $today, int $yesterday): string
    {
        if ($yesterday === 0) {
            return $today > 0 ? trans('admin.more_than_yesterday') : trans('admin.same_as_yesterday');
        }

        $diff = (int) round((($today - $yesterday) / $yesterday) * 100);
        $sign = $diff >= 0 ? '+' : '';

        return trans('admin.percent_vs_yesterday', ['percent' => $sign.$diff]);
    }
}
