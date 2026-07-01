<?php

namespace App\Filament\Resources\Links\Tables;

use App\Filament\Actions\Links\OpenOriginalUrlAction;
use App\Filament\Actions\Links\OpenShortUrlAction;
use App\Filament\Actions\Links\ShareLinkAction;
use App\Filament\Tables\Columns\AdminIDColumn;
use App\Filament\Tables\Columns\AdminTextColumn;
use App\Filament\Tables\Columns\AdminTimeStampColumn;
use App\Filament\Tables\Columns\AdminToggleColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class LinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                AdminIDColumn::make('id'),

                AdminTextColumn::make('user.name')
                    ->label(trans('admin.user'))
                    ->description(fn($record) => $record->user->email),

                AdminTextColumn::make('title'),

                AdminTextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                AdminTextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                AdminTextColumn::make('clicks')
                    ->label(trans('admin.clicks'))
                    ->badge(),

                AdminToggleColumn::make(),

                AdminTimeStampColumn::make('expires_at')
                    ->label(trans('admin.expires_at'))
                    ->default(Carbon::create(9999, 12, 31, 23, 59, 59))
                    ->badge(),

                AdminTimeStampColumn::make('created_at'),

                AdminTimeStampColumn::make('updated_at')
                    ->label(trans('admin.updated_at')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    ShareLinkAction::make(),
                    OpenOriginalUrlAction::make()
                        ->visible(auth()->user()->isAdmin()),
                    OpenShortUrlAction::make()
                        ->visible(auth()->user()->isAdmin()),

                ])->button()->size(Size::ExtraLarge)
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
