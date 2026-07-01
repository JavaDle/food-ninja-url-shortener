<?php

namespace App\Filament\Actions\Links;

use Filament\Actions\Action;

class OpenShortUrlAction
{
    public static function make(): Action
    {
        return Action::make('open_short_url')
            ->label(trans('admin.open_short_url'))
            ->icon('heroicon-o-arrow-top-right-on-square')
            ->url(fn ($record) => route('links.redirect', $record->short_code))
            ->openUrlInNewTab();
    }
}
