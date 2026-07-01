<?php

namespace App\Filament\Actions\Links;

use Filament\Actions\Action;

class OpenOriginalUrlAction
{
    public static function make(): Action
    {
        return Action::make('open_original_url')
            ->label(trans('admin.open_original_url'))
            ->icon('heroicon-o-globe-alt')
            ->url(fn($record) => $record->original_url)
            ->openUrlInNewTab();
    }
}
