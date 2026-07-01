<?php

namespace App\Filament\Plugins\LocaleSwitcher;

use Closure;
use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Forms\Components\Field;
use Filament\Panel;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Model;

class TranslatablePlugin implements Plugin
{
    protected array|Closure $supportedLocales = [];

    // ─────────────────────────────────────────────────────────────
    //  Plugin contract
    // ─────────────────────────────────────────────────────────────

    public function getId(): string
    {
        return 'tx:translatable-plugin';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        $supportedLocales = $this->getSupportedLocales();

        /**
         * ->translatable()  macro on any Filament Field.
         */
        Field::macro('translatable', function (
            bool $translatable = true,
            ?array $customLocales = null,
            ?array $localeSpecificRules = null,
        ) use ($supportedLocales) {
            /** @var Field $this */
            if (! $translatable) {
                return $this;
            }

            $originalField = $this->getClone();
            $originalName = $originalField->getName();
            $originalLabel = $originalField->getLabel();
            $originalStatePath = $originalField->getStatePath(false); // path without the field name itself

            $locales = $customLocales ?? $supportedLocales;

            // Используем values() для сброса ключей, чтобы гарантировать корректный $index от 0 до N
            $tabs = collect($locales)
                ->values()
                ->map(function ($labelOrLocale, $index) use (
                    $locales,
                    $originalField,
                    $originalName,
                    $originalLabel,
                    $originalStatePath,
                    $localeSpecificRules,
                ) {
                    // Восстанавливаем оригинальный ключ для ассоциативных массивов типа ['ru' => 'Русский']
                    $keys = array_keys($locales);
                    $keyOrIndex = $keys[$index];

                    // Support both ['ru' => 'Русский'] and ['ru', 'en']
                    $locale = is_string($keyOrIndex) ? $keyOrIndex : $labelOrLocale;
                    $tabLabel = is_string($keyOrIndex) ? $labelOrLocale : strtoupper($locale);

                    // Flat state key: "title_ru" — avoids Filament treating it as nested array
                    $stateKey = "{$originalName}_{$locale}";

                    $clone = $originalField
                        ->getClone()
                        ->name($stateKey)
                        ->label($originalLabel)
                        // statePath must also be flat; rebuild from original parent path
                        ->statePath(
                            $originalStatePath
                                ? "{$originalStatePath}.{$stateKey}"
                                : $stateKey
                        )
                        // Only include in form submission if a value is present
                        ->dehydrated(fn ($state) => filled($state))
                        // ── READ: pull value from Translation rows ──────────────
                        ->afterStateHydrated(function (Field $component, $state, $record) use ($locale, $originalName) {
                            if ($record instanceof Model && method_exists($record, 'getTranslation')) {
                                $component->state(
                                    $record->getTranslation($originalName, $locale, useFallback: false)
                                );
                            }
                        })
                        // ── WRITE: push value into Translation rows ─────────────
                        ->saveRelationshipsUsing(function (Field $component, $record, $state) use ($locale, $originalName) {
                            if ($record instanceof Model && method_exists($record, 'setTranslation')) {
                                if (filled($state)) {
                                    $record->setTranslation($originalName, $locale, (string) $state);
                                } elseif (method_exists($record, 'forgetTranslation')) {
                                    // Если поле пустое — физически удаляем строку перевода из базы данных
                                    $record->forgetTranslation($originalName, $locale);
                                }
                            }
                        });

                    // ── КРИТИЧЕСКИЙ ОПТИМИЗАТОР ВАЛИДАЦИИ ДЛЯ FILAMENT 5 ──
                    // Если это НЕ первая локаль (дополнительный перевод), принудительно отключаем required
                    if ($index > 0) {
                        $clone->required(false);
                    }

                    // Apply locale-specific validation rules if provided
                    if ($localeSpecificRules && isset($localeSpecificRules[$locale])) {
                        $clone->rules($localeSpecificRules[$locale]);
                    }

                    return Tab::make($locale)
                        ->label($tabLabel)
                        ->schema([$clone]);
                })
                ->toArray();

            return Tabs::make("{$originalName}_translations")
                ->tabs($tabs);
        });
    }

    // ─────────────────────────────────────────────────────────────
    //  Locale configuration
    // ─────────────────────────────────────────────────────────────

    public function supportedLocales(array|Closure $supportedLocales): static
    {
        $this->supportedLocales = $supportedLocales;

        return $this;
    }

    public function getSupportedLocales(): array
    {
        $locales = is_callable($this->supportedLocales)
            ? call_user_func($this->supportedLocales)
            : $this->supportedLocales;

        if (empty($locales)) {
            $locales[] = config('app.locale');
        }

        return $locales;
    }

    // ─────────────────────────────────────────────────────────────
    //  Static accessor
    // ─────────────────────────────────────────────────────────────

    public static function get(): Plugin|FilamentManager
    {
        return filament(app(static::class)->getId());
    }
}
