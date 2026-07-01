<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(trans('admin.general'))
                    ->schema([
                        TextInput::make('name')
                            ->label(trans('filament-panels::auth/pages/edit-profile.form.name.label'))
                            ->required(),

                        TextInput::make('email')
                            ->label(trans('filament-panels::auth/pages/edit-profile.form.email.label'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->live(debounce: 500),

                        TextInput::make('password')
                            ->label(trans('filament-panels::auth/pages/edit-profile.form.password.label'))
                            ->validationAttribute(trans('filament-panels::auth/pages/edit-profile.form.password.validation_attribute'))
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->rule(Password::default())
                            ->showAllValidationMessages()
                            ->autocomplete('new-password')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation'),

                        DateTimePicker::make('email_verified_at')
                            ->label(trans('admin.email_verified')),
                    ])
                    ->columns()
                    ->columnSpanFull()
            ]);
    }
}
