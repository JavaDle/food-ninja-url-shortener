<x-filament::dropdown placement="bottom-start" class="p-2">
    <x-slot name="trigger" class="fi-sidebar-database-notifications-btn">
        @if (isset($currentLanguage) && $showFlags)
            <div class="fi-icon fi-size-lg w-8">
                {{ svg('flag-4x3-'.$currentLanguage['flag'],'rounded-sm') }}
            </div>
            <div x-show="$store.sidebar.isOpen"
                 x-transition:enter="fi-transition-enter"
                 x-transition:enter-start="fi-transition-enter-start"
                 x-transition:enter-end="fi-transition-enter-end"
                 class="fi-sidebar-database-notifications-btn-label">
                {{$currentLanguage['name']}}
            </div>
        @else
            <x-filament::icon-button icon="heroicon-o-language" label="{{ trans('alisa-core::ui.language_switcher') }}"/>
        @endif
    </x-slot>

    <x-filament::dropdown.list class="max-h-80 overflow-y-auto">
        @foreach ($otherLanguages as $language)
            @php
                $isCurrent = isset($currentLanguage) && $currentLanguage['code'] === $language['code'];
            @endphp
            <x-filament::dropdown.list.item
                :href="route('locale-switcher.switch', ['code' => $language['code']])"
                tag="a"
                onclick="location.reload()"
            >
                <span class="flex items-center gap-3 w-full text-left truncate">
                    @if ($showFlags)
                        <div class="w-8 shrink-0">
                            {{ svg('flag-4x3-'.$language['flag'],'rounded-sm') }}
                        </div>
                        <span class="truncate">{{ $language['name'] }}</span>
                    @else
                        <span class="{{ $isCurrent ? 'font-semibold' : 'font-normal' }}">
                            {{ strtoupper($language['code']) }} - {{ $language['name'] }}
                        </span>
                    @endif
                </span>
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
