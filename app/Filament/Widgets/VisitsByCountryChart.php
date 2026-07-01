<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Visit;
use Filament\Widgets\ChartWidget;

class VisitsByCountryChart extends ChartWidget
{
    protected ?string $heading = null;

    protected ?string $description = null;

    protected static ?int $sort = 4;

    protected static bool $isLazy = true;

    protected int|string|array $columnSpan = [
        'md' => 1,
    ];

    protected ?string $maxHeight = '320px';

    public function getHeading(): ?string
    {
        return trans('admin.visits_by_country');
    }

    public function getDescription(): ?string
    {
        return trans('admin.top_countries_description');
    }

    /**
     * Палитра, гармонирующая с основным акцентным цветом панели.
     *
     * @var array<int, string>
     */
    private const array PALETTE = [
        '#6366f1', '#22c55e', '#f59e0b', '#ec4899',
        '#06b6d4', '#8b5cf6', '#ef4444', '#94a3b8',
    ];

    protected function getData(): array
    {
        $counts = Visit::query()
            ->selectRaw('country, COUNT(*) as total')
            ->groupBy('country')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'country' => filled($row->country) ? $row->country : trans('admin.not_specified'),
                'total' => (int) $row->total,
            ]);

        $top = $counts->take(7);
        $otherTotal = $counts->skip(7)->sum('total');

        $labels = $top->pluck('country')->all();
        $data = $top->pluck('total')->all();

        if ($otherTotal > 0) {
            $labels[] = trans('admin.other');
            $data[] = $otherTotal;
        }

        return [
            'datasets' => [
                [
                    'label' => trans('admin.visits'),
                    'data' => $data,
                    'backgroundColor' => array_slice(self::PALETTE, 0, count($data)),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                    'hoverOffset' => 8,
                ],
            ],
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
                    'labels' => [
                        'usePointStyle' => true,
                        'boxWidth' => 8,
                    ],
                ],
            ],
        ];
    }
}
