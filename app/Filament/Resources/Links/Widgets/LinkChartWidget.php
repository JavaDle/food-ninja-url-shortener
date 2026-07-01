<?php

namespace App\Filament\Resources\Links\Widgets;

use App\Models\Link;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;

abstract class LinkChartWidget extends ChartWidget
{
    public ?Link $record = null;

    protected int|string|array $columnSpan = [
        'md' => 1,
    ];

    protected ?string $maxHeight = '320px';

    protected function visits()
    {
        return $this->record->visits();
    }
}
