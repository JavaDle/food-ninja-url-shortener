<?php

namespace App\Filament\Resources\Links\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class LinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(trans('admin.general'))
                    ->schema([
                        TextInput::make('title')
                            ->label(trans('admin.title'))
                            ->maxLength(255)
                            ->required(),

                        TextInput::make('short_code')
                            ->label(trans('admin.short_code'))
                            ->maxLength(32)
                            ->unique(ignoreRecord: true)
                            ->helperText(trans('admin.leave_your_custom_short_code'))
                            ->alphaDash()
                            ->suffixAction(
                                Action::make('generate')
                                    ->icon('heroicon-m-arrow-path')
                                    ->tooltip(trans('admin.generate'))
                                    ->action(function (Set $set) {
                                        $set('short_code', Str::password(
                                            length: 8,
                                            symbols: false,
                                        ));
                                    })
                            )
                            ->visible(auth()->user()->isAdmin()),

                        DateTimePicker::make('expires_at')
                            ->label(trans('admin.expires_at')),

                        TextInput::make('original_url')
                            ->label(trans('admin.original_url'))
                            ->url()
                            ->required()
                            ->maxLength(2048)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label(trans('admin.is_active'))
                            ->default(true),
                    ])
                    ->columns(auth()->user()->isAdmin() ? 3 : 2)
                    ->columnSpanFull()
            ]);
    }
}
