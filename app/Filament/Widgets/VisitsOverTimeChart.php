<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Visit;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class VisitsOverTimeChart extends ChartWidget
{
    protected ?string $heading = null;

    protected ?string $description = null;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '320px';

    public ?string $filter = 'month';

    protected static bool $isLazy = true;

    public function getHeading(): ?string
    {
        return trans('admin.visits_over_time');
    }

    public function getDescription(): ?string
    {
        return trans('admin.visits_dynamics_for_period');
    }

    protected function getFilters(): ?array
    {
        return [
            'week' => trans('admin.last_7_days'),
            'month' => trans('admin.last_30_days'),
            'year' => trans('admin.last_12_months'),
        ];
    }

    protected function getData(): array
    {
        [$trend, $labelFormat] = match ($this->filter) {
            'week' => [
                Trend::model(Visit::class)
                    ->between(start: now()->subDays(6)->startOfDay(), end: now()->endOfDay())
                    ->dateColumn('visited_at')
                    ->perDay(),
                'd.m',
            ],
            'year' => [
                Trend::model(Visit::class)
                    ->between(start: now()->subMonths(11)->startOfMonth(), end: now()->endOfMonth())
                    ->dateColumn('visited_at')
                    ->perMonth(),
                'M Y',
            ],
            default => [
                Trend::model(Visit::class)
                    ->between(start: now()->subDays(29)->startOfDay(), end: now()->endOfDay())
                    ->dateColumn('visited_at')
                    ->perDay(),
                'd.m',
            ],
        };

        $data = $trend->count();

        return [
            'datasets' => [
                [
                    'label' => trans('admin.visits'),
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->all(),
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.15)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointRadius' => 2,
                ],
            ],
            'labels' => $data
                ->map(fn (TrendValue $value) => Carbon::parse($value->date)->translatedFormat($labelFormat))
                ->all(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
