<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Actions\Users\ResendEmailVerificationAction;
use App\Filament\Tables\Columns\AdminIDColumn;
use App\Filament\Tables\Columns\AdminTextColumn;
use App\Filament\Tables\Columns\AdminTimeStampColumn;
use App\Filament\Tables\Columns\AdminToggleColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\Size;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                AdminIDColumn::make('id'),

                AdminTextColumn::make('name')
                    ->label(trans('filament-panels::auth/pages/edit-profile.form.name.label')),

                AdminTextColumn::make('email')
                    ->label(trans('filament-panels::auth/pages/edit-profile.form.email.label')),

                AdminToggleColumn::make('email_verified_at')
                    ->label(trans('admin.email_verified'))
                    ->getStateUsing(fn ($record): bool => $record->email_verified_at !== null)
                    ->beforeStateUpdated(function ($record, bool $state): void {
                        $record->forceFill([
                            'email_verified_at' => $state ? now() : null,
                        ])->save();
                    })
                    ->updateStateUsing(fn () => null),

                AdminTimeStampColumn::make('created_at'),

                AdminTimeStampColumn::make('updated_at')
                    ->label(trans('admin.updated_at')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    ResendEmailVerificationAction::make()
                ])->button()->size(Size::ExtraLarge)
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->reorderableColumns()
            ->deferLoading()
            ->emptyStateHeading(trans('admin.data_not_found_or_not_added'))
            ->emptyStateDescription(trans('admin.as_soon_as_the_data_appears_it_will_be_displayed_here'))
            ->emptyStateIcon('heroicon-o-information-circle');
    }
}
