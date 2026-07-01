<?php

namespace App\Filament\Actions\Users;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Auth\Notifications\VerifyEmail;
use Filament\Notifications\Notification;

class ResendEmailVerificationAction
{
    public static function make()
    {
        return Action::make('resend_verification_email')
            ->label(trans('admin.resend_verification_email'))
            ->icon('heroicon-o-envelope')
            ->color('success')
            ->authorize(fn(User $record) => !$record->hasVerifiedEmail())
            ->action(function (User $record) {
                $notification = new VerifyEmail();
                $notification->url = filament()->getVerifyEmailUrl($record);
                $record->notify($notification);

                Notification::make()
                    ->success()
                    ->title(trans('admin.verification_email_has_been_resent'))
                    ->send();
            })
            ->requiresConfirmation();
    }
}
