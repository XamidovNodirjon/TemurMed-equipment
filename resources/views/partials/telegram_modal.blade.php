@php
    $tgChannelUrl = config('services.telegram.channel_url');
    $tgHandle = '@' . ltrim(parse_url($tgChannelUrl, PHP_URL_PATH) ?? '', '/');
    $tgButtonUrl = route('telegram.go', ['src' => 'button']);
    $tgQrSvg = \App\Support\QrCode::svg(route('telegram.go', ['src' => 'qr']));
    $tgLogoPath = 'M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z';
@endphp

{{-- Telegram kanal reklama modali: saytga har kirilganda 1 marta chiqadi, yopilgach shu tashrifda qayta chiqmaydi --}}
<div x-data="{
        open: false,
        storageGet(store, key) { try { return window[store].getItem(key); } catch (e) { return null; } },
        storageSet(store, key, value) { try { window[store].setItem(key, value); } catch (e) {} },
        init() {
            // Har bir tashrifda (brauzer sessiyasi) faqat 1 marta chiqadi
            if (this.storageGet('sessionStorage', 'tg_promo_seen')) return;
            setTimeout(() => this.show(), 1500);
        },
        show() {
            this.open = true;
            this.storageSet('sessionStorage', 'tg_promo_seen', '1');
            document.documentElement.classList.add('overflow-hidden');
            this.$nextTick(() => this.$refs.joinButton?.focus({ preventScroll: true }));
        },
        close() {
            this.open = false;
            document.documentElement.classList.remove('overflow-hidden');
        },
        joined() {
            setTimeout(() => this.close(), 150);
        }
    }"
    x-on:keydown.escape.window="open && close()"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-[110]"
    role="dialog"
    aria-modal="true"
    aria-labelledby="tg-promo-title">

    {{-- Fon --}}
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
         aria-hidden="true"></div>

    {{-- Mobil: pastdan chiquvchi panel, desktop: markazda --}}
    <div class="absolute inset-0 flex items-end sm:items-center justify-center sm:p-6 overflow-y-auto"
         x-on:click.self="close()">
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
             class="relative w-full sm:max-w-md bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden max-h-[92vh] sm:max-h-none overflow-y-auto">

            {{-- Mobil "tutqich" --}}
            <div class="sm:hidden absolute top-2 left-1/2 -translate-x-1/2 h-1.5 w-10 rounded-full bg-white/50 z-10"></div>

            {{-- Yopish --}}
            <button type="button"
                    x-on:click="close()"
                    class="absolute top-3 right-3 z-10 inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/15 text-white hover:bg-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white transition"
                    aria-label="{{ __('telegram.close') }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            {{-- Sarlavha qismi --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-[#2AABEE] to-[#1C8ADB] px-6 pt-8 pb-7 sm:px-8 text-center text-white">
                <div class="pointer-events-none absolute -top-16 -right-16 h-48 w-48 rounded-full bg-white/10"></div>
                <div class="pointer-events-none absolute -bottom-20 -left-12 h-44 w-44 rounded-full bg-white/10"></div>

                <div class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-lg shadow-sky-900/20">
                    <svg class="h-16 w-16 text-[#2AABEE]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="{{ $tgLogoPath }}"/></svg>
                    <span class="absolute -right-0.5 -top-0.5 flex h-4 w-4">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-300 opacity-75"></span>
                        <span class="relative inline-flex h-4 w-4 rounded-full border-2 border-white bg-emerald-400"></span>
                    </span>
                </div>

                <span class="relative mt-4 inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-wider">
                    {{ __('telegram.badge') }}
                </span>
                <h3 id="tg-promo-title" class="relative mt-3 text-2xl font-extrabold leading-tight">
                    {{ __('telegram.title') }}
                </h3>
                <p class="relative mt-2 text-sm leading-relaxed text-white/90">
                    {{ __('telegram.desc') }}
                </p>
            </div>

            {{-- Asosiy qism --}}
            <div class="px-6 pt-5 sm:px-8 pb-[max(1.5rem,env(safe-area-inset-bottom))] sm:pb-8">
                <ul class="flex flex-wrap justify-center gap-2">
                    @foreach (['perk_1', 'perk_2', 'perk_3'] as $perk)
                        <li class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            {{ __('telegram.' . $perk) }}
                        </li>
                    @endforeach
                </ul>

                {{-- QR kod: telefonning o'zida skaner qilib bo'lmaydi, shuning uchun faqat planshet/kompyuterda --}}
                <div class="hidden sm:flex mt-6 items-center gap-5 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="relative h-32 w-32 shrink-0 rounded-xl bg-white p-2 shadow-sm ring-1 ring-slate-200">
                        {!! $tgQrSvg !!}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white ring-4 ring-white">
                                <svg class="h-8 w-8 text-[#2AABEE]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="{{ $tgLogoPath }}"/></svg>
                            </span>
                        </div>
                    </div>
                    <div class="min-w-0 text-left">
                        <div class="flex items-center gap-2 text-slate-900">
                            <svg class="h-5 w-5 shrink-0 text-[#2AABEE]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2M7 12h10"/></svg>
                            <p class="text-sm font-bold leading-snug">{{ __('telegram.scan') }}</p>
                        </div>
                        <p class="mt-2 truncate text-base font-semibold text-[#1C8ADB]">{{ $tgHandle }}</p>
                    </div>
                </div>

                <div class="hidden sm:flex my-4 items-center gap-3 text-xs font-medium uppercase tracking-wider text-slate-400">
                    <span class="h-px flex-1 bg-slate-200"></span>
                    {{ __('telegram.or') }}
                    <span class="h-px flex-1 bg-slate-200"></span>
                </div>

                <a href="{{ $tgButtonUrl }}"
                   target="_blank"
                   rel="noopener nofollow"
                   x-ref="joinButton"
                   x-on:click="joined()"
                   class="group mt-5 sm:mt-0 flex w-full items-center justify-center gap-2.5 rounded-2xl bg-[#2AABEE] px-6 py-4 text-base font-bold text-white shadow-lg shadow-sky-500/30 transition hover:bg-[#1C8ADB] active:scale-[0.98] focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-300">
                    <svg class="h-5 w-5 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"/></svg>
                    {{ __('telegram.join') }}
                </a>

                <button type="button"
                        x-on:click="close()"
                        class="mt-3 w-full rounded-xl py-2.5 text-sm font-semibold text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                    {{ __('telegram.later') }}
                </button>
            </div>
        </div>
    </div>
</div>
