<?php

namespace App\Filament\Resources\Links\Pages;

use App\Filament\Resources\Links\LinkResource;
use App\Filament\Resources\Links\Widgets\VisitsByCityChart;
use App\Filament\Resources\Links\Widgets\VisitsByCountryChart;
use App\Filament\Resources\Links\Widgets\VisitsByIpChart;
use App\Filament\Resources\Links\Widgets\VisitsByRefererChart;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLink extends ViewRecord
{
    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return [
            'md' => 4,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            VisitsByCountryChart::class,
            VisitsByCityChart::class,
            VisitsByIpChart::class,
            VisitsByRefererChart::class,
        ];
    }
}
