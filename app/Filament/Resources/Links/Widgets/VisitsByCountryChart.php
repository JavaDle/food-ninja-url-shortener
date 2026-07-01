<?php

namespace App\Filament\Resources\Links\Widgets;

use Illuminate\Contracts\Support\Htmlable;

class VisitsByCountryChart extends LinkChartWidget
{
    protected static bool $isLazy = true;

    public function getHeading(): string|Htmlable|null
    {
        return trans('admin.countries');
    }

    private const array PALETTE = [
        '#6366f1',
        '#22c55e',
        '#f59e0b',
        '#ef4444',
        '#06b6d4',
        '#8b5cf6',
        '#ec4899',
        '#94a3b8',
    ];

    protected function getData(): array
    {
        $countries = $this->visits()
            ->selectRaw('country, COUNT(*) total')
            ->whereNotNull('country')
            ->where('country', '<>', '')
            ->groupBy('country')
            ->orderByDesc('total')
            ->get();

        $top = $countries->take(7);

        $other = $countries
            ->skip(7)
            ->sum('total');

        $labels = $top
            ->pluck('country')
            ->all();

        $data = $top
            ->pluck('total')
            ->all();

        if ($other > 0) {
            $labels[] = trans('admin.other');
            $data[] = $other;
        }

        return [
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => array_slice(self::PALETTE, 0, count($data)),
                'borderWidth' => 2,
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
