<x-filament-panels::layout.base>
    <div class="relative min-h-screen overflow-x-hidden">
        {{-- NOISE OVERLAY --}}
        <div
            class="fixed inset-0 z-[9999] pointer-events-none opacity-[0.02]"
            style="background-image: url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E&quot;)"
        ></div>

        {{-- AMBIENT GLOW ORBS --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute left-1/2 -translate-x-1/2 w-[130vw] max-w-[900px] aspect-square -top-64 rounded-full bg-[radial-gradient(circle,rgba(255,106,0,0.07)_0%,transparent_65%)]" style="animation: pulse-glow 8s ease-in-out infinite"></div>
            <div class="absolute top-[40%] -right-48 w-[600px] h-[600px] rounded-full bg-[radial-gradient(circle,rgba(255,106,0,0.04)_0%,transparent_65%)]" style="animation: pulse-glow 12s ease-in-out infinite 3s"></div>
        </div>

        {{-- NAVIGATION --}}
        <nav class="fixed top-0 inset-x-0 z-[100] px-6 md:px-12 py-5 flex items-center justify-between backdrop-blur-xl bg-bg/60 border-b border-border/50 opacity-0 animate-[fadeDown_0.7s_ease_forwards]">
            <a href="{{ url('/') }}"
               class="font-display text-[1.6rem] text-text-primary no-underline tracking-[-0.03em] transition-opacity duration-300 hover:opacity-70">
                Url<span class="text-accent">.</span>Shortener
            </a>

            <ul class="flex items-center gap-6 md:gap-10 list-none">
                <li class="hidden md:block">
                    <a href="#features" class="font-mono-alt text-text-muted no-underline text-[0.65rem] md:text-[0.7rem] tracking-[0.12em] uppercase transition-all duration-300 hover:text-accent">
                        @lang('web.nav_features')
                    </a>
                </li>
                @if(filament()->hasLogin())
                    <li>
                        <a href="{{ filament()->getLoginUrl() }}" class="font-mono-alt text-text-muted no-underline text-[0.65rem] md:text-[0.7rem] tracking-[0.12em] uppercase transition-all duration-300 hover:text-accent">
                            @auth
                                @lang('web.nav_cabinet')
                            @endauth
                            @guest
                                @lang('web.nav_login')
                            @endguest
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        {{-- HERO SECTION --}}
        <section class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 md:px-8 pt-32 pb-20">

            {{-- Decorative geometry (desktop only) --}}
            <div class="absolute top-[18%] left-[8%] hidden md:block w-px h-40 bg-gradient-to-b from-transparent via-accent/15 to-transparent opacity-0 animate-[fadeUp_1.2s_ease_0.6s_forwards]"></div>
            <div class="absolute top-[22%] right-[12%] hidden md:block w-px h-24 bg-gradient-to-b from-transparent via-border/30 to-transparent opacity-0 animate-[fadeUp_1.2s_ease_0.8s_forwards]"></div>
            <div class="absolute top-[30%] right-[22%] hidden md:block w-[5px] h-[5px] rounded-full bg-accent/30 opacity-0" style="animation: fadeUp 0.8s ease 1s forwards, float 6s ease-in-out infinite 1s"></div>
            <div class="absolute bottom-[28%] left-[18%] hidden md:block w-[3px] h-[3px] rounded-full bg-accent/20 opacity-0" style="animation: fadeUp 0.8s ease 1.2s forwards, float-alt 8s ease-in-out infinite 1.2s"></div>
            <div class="absolute top-[45%] left-[6%] hidden md:block w-[4px] h-[4px] rounded-full border border-accent/20 opacity-0" style="animation: fadeUp 0.8s ease 1.4s forwards, float 10s ease-in-out infinite 1.4s"></div>

            {{-- Central gradient orb --}}
            <div class="absoluteleft-1/2top-0-translate-x-1/2pointer-events-nonew-[110vw]max-w-[750px]aspect-squarebg-[radial-gradient(circle,rgba(255,106,0,0.09)_0%,rgba(255,106,0,0.02)_40%,transparent_70%)]"></div>

            {{-- Badge --}}
            <div class="relative opacity-0 inline-flex items-center gap-2.5 px-5 py-2 border border-border/50 rounded-full font-mono-alt text-[0.65rem] text-accent tracking-[0.18em] uppercase mb-10 backdrop-blur-sm animate-[fadeUp_0.7s_ease_0.2s_forwards]">
                <span class="w-[6px] h-[6px] rounded-full bg-accent animate-pulse"></span>
                @lang('web.hero_badge')
            </div>

            {{-- Heading --}}
            <h1 class="relative opacity-0 font-display text-[clamp(2.6rem,8vw,6rem)] leading-[0.98] tracking-[-0.03em] max-w-[900px] mb-8 animate-[fadeUp_0.8s_ease_0.35s_forwards]">
                @lang('web.hero_title_part1')<br>
                <span class="text-accent italic relative inline-block">
                    @lang('web.hero_title_part2')
                    <span class="absolute -bottom-1 left-0 w-full h-px bg-gradient-to-r from-accent/50 via-accent/30 to-transparent origin-left opacity-0" style="animation: draw-line 1s ease 0.9s forwards"></span>
                </span>
            </h1>

            {{-- Subtitle --}}
            <p class="relative opacity-0 font-mono-alt text-[0.82rem] text-text-muted max-w-[460px] leading-[1.9] mb-14 animate-[fadeUp_0.7s_ease_0.5s_forwards]">
                @lang('web.hero_subtitle')
            </p>

            {{-- CTA --}}
            @if(filament()->hasRegistration())
                <a href="{{ filament()->getRegistrationUrl() }}" class="group relative opacity-0 inline-flex items-center gap-3.5 py-[18px] px-12 bg-accent text-bg font-mono-alt text-[0.75rem] tracking-[0.1em] uppercase no-underline rounded-xl transition-all duration-500 hover:shadow-[0_0_80px_rgba(255,106,0,0.25),0_8px_32px_rgba(255,106,0,0.15)] hover:-translate-y-[3px] active:translate-y-0 animate-[fadeUp_0.7s_ease_0.65s_forwards]">
                    @lang('web.hero_cta')
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1">
                        <path d="M3 8h10M9 4l4 4-4 4"/>
                    </svg>
                </a>
            @endif

            {{-- Scroll hint --}}
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-3 opacity-0 animate-[fadeUp_0.7s_ease_1.2s_forwards]">
                <span class="font-mono-alt text-[0.5rem] text-text-muted/35 tracking-[0.25em] uppercase">Scroll</span>
                <div class="w-px h-10 bg-gradient-to-b from-text-muted/20 to-transparent" style="animation: scroll-hint 2.5s ease-in-out infinite"></div>
            </div>
        </section>

        {{-- DIVIDER --}}
        <div class="max-w-[1300px] mx-auto px-6 md:px-16">
            <div class="h-px bg-gradient-to-r from-transparent via-border/40 to-transparent"></div>
        </div>

        {{-- FEATURES SECTION --}}
        <section class="relative py-28 px-6 md:px-16 max-w-[1300px] mx-auto" id="features">

            {{-- Section header --}}
            <div class="flex items-center gap-5 mb-20 opacity-0 animate-[fadeUp_0.6s_ease_0.1s_forwards]">
                <span class="font-mono-alt text-[0.6rem] text-accent tracking-[0.2em] uppercase">@lang('web.nav_features')</span>
                <div class="flex-1 h-px bg-gradient-to-r from-border/60 to-transparent"></div>
                <span class="font-mono-alt text-[0.55rem] text-text-muted/30 tracking-[0.2em]">01 / 03</span>
            </div>

            {{-- Cards grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- Feature 1 --}}
                <div class="group relative opacity-0 bg-surface/40 backdrop-blur-sm border border-border/30 rounded-2xl py-14 px-9 overflow-hidden transition-all duration-500 hover:border-accent/25 hover:bg-surface/70 animate-[fadeUp_0.6s_ease_0.2s_forwards]">
                    <div class="absolute inset-0 bg-gradient-to-br from-accent/[0.03] to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                    <div class="absolute top-7 right-8 font-mono-alt text-[0.55rem] text-text-muted/15 tracking-[0.15em]">01</div>
                    <div class="relative w-14 h-14 rounded-2xl bg-accent/[0.06] border border-accent/10 flex items-center justify-center mb-8 transition-all duration-500 group-hover:border-accent/25 group-hover:shadow-[0_0_30px_rgba(255,106,0,0.08)]">
                        <svg class="w-6 h-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                        </svg>
                    </div>
                    <h3 class="relative text-[1.15rem] tracking-[-0.01em] mb-4 font-medium">@lang('web.feature_1_title')</h3>
                    <p class="relative text-[0.82rem] text-text-muted leading-[1.85]">@lang('web.feature_1_text')</p>
                </div>

                {{-- Feature 2 --}}
                <div class="group relative opacity-0 bg-surface/40 backdrop-blur-sm border border-border/30 rounded-2xl py-14 px-9 overflow-hidden transition-all duration-500 hover:border-accent/25 hover:bg-surface/70 animate-[fadeUp_0.6s_ease_0.3s_forwards]">
                    <div class="absolute inset-0 bg-gradient-to-br from-accent/[0.03] to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                    <div class="absolute top-7 right-8 font-mono-alt text-[0.55rem] text-text-muted/15 tracking-[0.15em]">02</div>
                    <div class="relative w-14 h-14 rounded-2xl bg-accent/[0.06] border border-accent/10 flex items-center justify-center mb-8 transition-all duration-500 group-hover:border-accent/25 group-hover:shadow-[0_0_30px_rgba(255,106,0,0.08)]">
                        <svg class="w-6 h-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </div>
                    <h3 class="relative text-[1.15rem] tracking-[-0.01em] mb-4 font-medium">@lang('web.feature_2_title')</h3>
                    <p class="relative text-[0.82rem] text-text-muted leading-[1.85]">@lang('web.feature_2_text')</p>
                </div>

                {{-- Feature 3 --}}
                <div class="group relative opacity-0 bg-surface/40 backdrop-blur-sm border border-border/30 rounded-2xl py-14 px-9 overflow-hidden transition-all duration-500 hover:border-accent/25 hover:bg-surface/70 animate-[fadeUp_0.6s_ease_0.4s_forwards]">
                    <div class="absolute inset-0 bg-gradient-to-br from-accent/[0.03] to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                    <div class="absolute top-7 right-8 font-mono-alt text-[0.55rem] text-text-muted/15 tracking-[0.15em]">03</div>
                    <div class="relative w-14 h-14 rounded-2xl bg-accent/[0.06] border border-accent/10 flex items-center justify-center mb-8 transition-all duration-500 group-hover:border-accent/25 group-hover:shadow-[0_0_30px_rgba(255,106,0,0.08)]">
                        <svg class="w-6 h-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                        </svg>
                    </div>
                    <h3 class="relative text-[1.15rem] tracking-[-0.01em] mb-4 font-medium">@lang('web.feature_3_title')</h3>
                    <p class="relative text-[0.82rem] text-text-muted leading-[1.85]">@lang('web.feature_3_text')</p>
                </div>
            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="relative py-16 px-6 md:px-12 border-t border-border/40">
            <div class="max-w-[1300px] mx-auto text-center opacity-0 animate-[fadeUp_0.6s_ease_0.2s_forwards]">
                <p class="font-mono-alt text-[0.65rem] text-text-muted/50 tracking-[0.1em]">
                    &copy; {{ now()->format('Y') }}. @lang('web.footer_text')
                </p>
            </div>
        </footer>
    </div>
</x-filament-panels::layout.base>
