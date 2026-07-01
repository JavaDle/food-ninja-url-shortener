<?php

namespace App\Filament\Resources\Links\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;

class LinkInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(trans('admin.general'))
                ->icon(Heroicon::OutlinedLink)
                ->schema([
                    TextEntry::make('title')
                        ->label(trans('admin.title'))
                        ->icon(Heroicon::OutlinedTag)
                        ->iconColor('primary')
                        ->placeholder('—')
                        ->weight(FontWeight::Medium),

                    TextEntry::make('short_code')
                        ->label(trans('admin.short_code'))
                        ->icon(Heroicon::OutlinedLink)
                        ->iconColor('primary')
                        ->badge()
                        ->color('primary')
                        ->copyable()
                        ->copyMessage(trans('admin.copied')),

                    TextEntry::make('original_url')
                        ->label(trans('admin.original_url'))
                        ->icon(Heroicon::OutlinedGlobeAlt)
                        ->iconColor('gray')
                        ->copyable()
                        ->copyMessage(trans('admin.copied'))
                        ->url(fn(?string $state): ?string => $state)
                        ->openUrlInNewTab()
                        ->columnSpanFull(),

                    IconEntry::make('is_active')
                        ->label(trans('admin.is_active'))
                        ->icon(Heroicon::OutlinedBolt)
                        ->boolean(),

                    TextEntry::make('expires_at')
                        ->label(trans('admin.expires_at'))
                        ->icon(Heroicon::OutlinedClock)
                        ->iconColor('warning')
                        ->placeholder('—')
                        ->since()
                        ->dateTimeTooltip(),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make(trans('admin.statistics'))
                ->icon(Heroicon::OutlinedChartBar)
                ->schema([
                    TextEntry::make('clicks')
                        ->label(trans('admin.clicks'))
                        ->icon(Heroicon::OutlinedCursorArrowRays)
                        ->iconColor('success')
                        ->badge()
                        ->color('success')
                        ->numeric(),

                    TextEntry::make('created_at')
                        ->label(trans('admin.created_at'))
                        ->icon(Heroicon::OutlinedCalendar)
                        ->iconColor('gray')
                        ->since()
                        ->dateTimeTooltip(),

                    TextEntry::make('first_visit')
                        ->label(trans('admin.first_visit'))
                        ->state(fn($record) => $record->visits()->oldest('visited_at')->value('visited_at'))
                        ->icon(Heroicon::OutlinedCalendar)
                        ->iconColor('gray')
                        ->since()
                        ->dateTimeTooltip(),

                    TextEntry::make('last_visit')
                        ->label(trans('admin.last_visit'))
                        ->state(fn($record) => $record->visits()->latest('visited_at')->value('visited_at'))
                        ->icon(Heroicon::OutlinedCalendar)
                        ->iconColor('gray')
                        ->since()
                        ->dateTimeTooltip(),
                ])
                ->columns(2)
                ->columnSpanFull(),
        ]);
    }
}
