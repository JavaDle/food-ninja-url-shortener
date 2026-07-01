<?php

namespace App\Filament\Resources\Visits\Tables;

use App\Filament\Tables\Columns\AdminIDColumn;
use App\Filament\Tables\Columns\AdminTextColumn;
use App\Filament\Tables\Columns\AdminTimeStampColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class VisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                AdminIDColumn::make('id'),

                AdminTextColumn::make('link.title')
                    ->label(trans('admin.link'))
                    ->description(fn($record) => $record->link->short_code),

                AdminTextColumn::make('country')
                    ->label(trans('admin.country'))
                    ->badge()
                    ->description(fn($record) => $record->city)
                    ->tooltip(fn($record) => $record->country),


                AdminTextColumn::make('city')
                    ->label(trans('admin.city'))
                    ->copyable()
                    ->tooltip(fn($record) => $record->city),

                AdminTextColumn::make('referer')
                    ->label(trans('admin.referer'))
                    ->limit(40),

                AdminTextColumn::make('user_agent')
                    ->label(trans('admin.user_agent'))
                    ->limit(60)
                    ->tooltip(fn($record) => $record->user_agent)
                    ->toggleable(isToggledHiddenByDefault: true),

                AdminTextColumn::make('visited_at')
                    ->label(trans('admin.visited_at'))
                    ->dateTime()
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
                    DeleteAction::make(),
                ])->button()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
