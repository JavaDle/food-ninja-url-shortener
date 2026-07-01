<?php

namespace App\Filament\Resources\Visits\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class VisitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(trans('admin.general'))
                ->icon(Heroicon::OutlinedCursorArrowRays)
                ->schema([
                    TextEntry::make('link.short_code')
                        ->label(trans('admin.short_code'))
                        ->icon(Heroicon::OutlinedLink)
                        ->iconColor('primary')
                        ->badge()
                        ->color('primary')
                        ->copyable()
                        ->copyMessage(trans('admin.copied')),

                    TextEntry::make('ip_address')
                        ->label(trans('admin.ip_address'))
                        ->icon(Heroicon::OutlinedGlobeAlt)
                        ->iconColor('gray')
                        ->fontFamily(FontFamily::Mono)
                        ->copyable()
                        ->copyMessage(trans('admin.copied')),

                    TextEntry::make('country')
                        ->label(trans('admin.country'))
                        ->icon(Heroicon::OutlinedFlag)
                        ->iconColor('info')
                        ->badge()
                        ->color('info')
                        ->placeholder('—'),

                    TextEntry::make('city')
                        ->label(trans('admin.city'))
                        ->icon(Heroicon::OutlinedMapPin)
                        ->iconColor('gray')
                        ->placeholder('—'),

                    TextEntry::make('visited_at')
                        ->label(trans('admin.visited_at'))
                        ->icon(Heroicon::OutlinedClock)
                        ->iconColor('gray')
                        ->since()
                        ->dateTimeTooltip()
                        ->weight(FontWeight::Medium),
                ])
                ->columns(2),

            Section::make(trans('admin.request'))
                ->icon(Heroicon::OutlinedCodeBracket)
                ->collapsible()
                ->schema([
                    TextEntry::make('referer')
                        ->label(trans('admin.referer'))
                        ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                        ->iconPosition(IconPosition::After)
                        ->iconColor('gray')
                        ->placeholder('—')
                        ->copyable()
                        ->copyMessage(trans('admin.copied'))
                        ->url(fn(?string $state): ?string => $state)
                        ->openUrlInNewTab()
                        ->columnSpanFull(),

                    TextEntry::make('user_agent')
                        ->label(trans('admin.user_agent'))
                        ->icon(Heroicon::OutlinedDevicePhoneMobile)
                        ->iconColor('gray')
                        ->fontFamily(FontFamily::Mono)
                        ->size(TextSize::Small)
                        ->placeholder('—')
                        ->copyable()
                        ->copyMessage(trans('admin.copied'))
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
