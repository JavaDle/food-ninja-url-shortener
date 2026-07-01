<?php

declare(strict_types=1);

namespace App\Filament\Resources\Links\Widgets;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class VisitsByRefererChart extends LinkChartWidget
{
    protected static bool $isLazy = true;

    public function getHeading(): string|Htmlable|null
    {
        return trans('admin.referers');
    }

    protected function getData(): array
    {
        $referers = $this->visits()
            ->selectRaw('referer, COUNT(*) as total')
            ->whereNotNull('referer')
            ->where('referer', '<>', '')
            ->groupBy('referer')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Переходы',
                    'data' => $referers->pluck('total')->all(),
                    'backgroundColor' => '#10b981',
                    'borderRadius' => 8,
                    'maxBarThickness' => 26,
                ],
            ],

            'labels' => $referers
                ->map(fn ($item) => Str::limit(parse_url($item->referer, PHP_URL_HOST) ?: $item->referer, 24))
                ->all(),
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
