<?php

declare(strict_types=1);

namespace App\Filament\Resources\Links\Widgets;

use Illuminate\Contracts\Support\Htmlable;

class VisitsByCityChart extends LinkChartWidget
{
    protected static bool $isLazy = true;

    public function getHeading(): string|Htmlable|null
    {
        return trans('admin.cities');
    }

    protected function getData(): array
    {
        $cities = $this->visits()
            ->selectRaw('city, COUNT(*) total')
            ->whereNotNull('city')
            ->where('city', '<>', '')
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => trans('admin.visits'),
                    'data' => $cities->pluck('total')->all(),
                    'backgroundColor' => '#f59e0b',
                    'borderRadius' => 8,
                    'maxBarThickness' => 26,
                ],
            ],

            'labels' => $cities->pluck('city')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',

            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],

            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
