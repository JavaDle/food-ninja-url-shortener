<?php

declare(strict_types=1);

namespace App\Filament\Resources\Links\Widgets;

use Illuminate\Contracts\Support\Htmlable;

class VisitsByIpChart extends LinkChartWidget
{
    protected static bool $isLazy = true;

    public function getHeading(): string|Htmlable|null
    {
        return trans('admin.top_ip');
    }

    protected function getData(): array
    {
        $ips = $this->visits()
            ->selectRaw('ip_address, COUNT(*) total')
            ->groupBy('ip_address')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return [
            'datasets' => [[
                'label' => trans('admin.visits'),
                'data' => $ips->pluck('total')->all(),
                'backgroundColor' => '#6366f1',
                'borderRadius' => 8,
                'maxBarThickness' => 26,
            ]],
            'labels' => $ips
                ->pluck('ip_address')
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
