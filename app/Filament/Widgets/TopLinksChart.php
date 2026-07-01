<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Link;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

class TopLinksChart extends ChartWidget
{
    protected ?string $heading = null;

    protected ?string $description = null;

    protected static ?int $sort = 3;

    protected static bool $isLazy = true;

    protected int|string|array $columnSpan = [
        'md' => 1,
    ];

    public function getHeading(): ?string
    {
        return trans('admin.top_links');
    }

    public function getDescription(): ?string
    {
        return trans('admin.by_number_of_clicks');
    }

    protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $links = Link::query()
            ->orderByDesc('clicks')
            ->limit(10)
            ->get(['id', 'title', 'short_code', 'clicks']);

        $labels = $links->map(
            fn (Link $link) => Str::limit($link->title ?: $link->short_code, 18)
        )->all();

        return [
            'datasets' => [
                [
                    'label' => trans('admin.clicks'),
                    'data' => $links->pluck('clicks')->all(),
                    'backgroundColor' => '#f59e0b',
                    'borderRadius' => 6,
                    'maxBarThickness' => 28,
                ],
            ],
            'labels' => $labels,
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
