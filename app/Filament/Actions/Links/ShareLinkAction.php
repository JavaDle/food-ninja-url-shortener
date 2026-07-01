<?php

namespace App\Filament\Actions\Links;

use Filament\Actions\Action;

class ShareLinkAction
{
    public static function make()
    {
        return Action::make(trans('share'))
            ->label(trans('admin.share'))
            ->icon('heroicon-o-share')
            ->action(function ($livewire, $record) {
                $title = $record->title;
                $url = route('links.redirect', $record->short_code);

                $livewire->js(<<<JS
                                navigator.share?.({
                                    title: '$title',
                                    url: '$url',
                                });
                            JS
                );
            });
    }
}
