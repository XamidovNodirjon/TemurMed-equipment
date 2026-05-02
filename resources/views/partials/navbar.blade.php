<div class="flex flex-col font-sans text-gray-900" x-data="{ mobileMenuOpen: false }">
    <!-- TOP BAR -->
    <div class="bg-slate-900 text-white text-[10px] sm:text-xs py-1.5 sm:py-2 relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-3 sm:space-x-6">
                <a href="tel:+998700591119" class="flex items-center hover:text-gray-300">
                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>+998 70 059 11 19</span>
                </a>
                <div class="hidden sm:flex items-center">
                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('navbar.top.working_hours') }}
                </div>
            </div>
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="hidden xs:flex items-center space-x-3 sm:space-x-4">
                    <a href="https://t.me/Temur_med_manager" class="hover:text-gray-300">{{ __('navbar.top.telegram') }}</a>
                    <a href="https://www.instagram.com/temurmedtechnical/" class="hover:text-gray-300">{{ __('navbar.top.instagram') }}</a>
                </div>
                
                <!-- Language Dropdown -->
                <div class="relative ml-2 sm:ml-4" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center text-gray-300 hover:text-white transition-colors focus:outline-none px-2 sm:px-3 py-1 sm:py-1.5 rounded-md hover:bg-slate-700 text-[10px] sm:text-xs">
                        <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="uppercase font-medium">{{ app()->getLocale() }}</span>
                        <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3 ml-1 transform transition-transform text-gray-400" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" 
                         class="absolute right-0 mt-2 w-32 bg-white text-gray-800 rounded-md shadow-xl z-50 py-2 border border-gray-100 transform origin-top-right scale-90 sm:scale-100" 
                         x-cloak 
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'uz'])) }}" 
                           class="flex items-center px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ app()->getLocale() == 'uz' ? 'bg-blue-50 text-blue-600 font-bold' : '' }}">
                           <span>O'zbek</span>
                        </a>
                        <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'ru'])) }}" 
                           class="flex items-center px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ app()->getLocale() == 'ru' ? 'bg-blue-50 text-blue-600 font-bold' : '' }}">
                           <span class="w-6 text-center text-sm mr-2">Русский</span>
                        </a>
                        <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}" 
                           class="flex items-center px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ app()->getLocale() == 'en' ? 'bg-blue-50 text-blue-600 font-bold' : '' }}">
                           <span class="w-6 text-center text-sm mr-2">English</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MIDDLE BAR -->
    <div class="bg-white py-4 border-b border-gray-100 relative z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center gap-4">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">
                    <img src="{{ asset('logo/logo.png') }}" alt="TemurMed" class="h-10 w-auto">
                </a>
            </div>

            <!-- Catalog & Search (Desktop only) -->
            <div class="hidden lg:flex flex-1 max-w-2xl items-center gap-2 relative">
                <!-- Catalog Dropdown -->
                <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                    <button class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        {{ __('navbar.middle.catalog') }}
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         class="absolute top-full left-0 mt-2 w-[800px] bg-white rounded-lg shadow-xl border border-gray-100 z-50 overflow-hidden" 
                         x-cloak
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2">
                        
                        <div class="p-6">
                            <ul class="grid grid-cols-3 gap-y-4 gap-x-6">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('catalog.category', ['locale' => app()->getLocale(), 'slug' => $category->slug]) }}" 
                                           class="flex items-center group p-2 -ml-2 rounded-md hover:bg-gray-50 transition-colors">
                                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">{{ $category->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="flex-1 relative">
                    <form action="{{ route('catalog.index', app()->getLocale()) }}" method="GET">
                        <input type="text" name="search" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm pl-4 pr-10 py-2" placeholder="{{ __('navbar.middle.search_placeholder') }}">
                        <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center hover:text-blue-600">
                            <svg class="h-5 w-5 text-gray-400 hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center">
                <!-- Phone Number & Icon (Number First, No Hover) -->
                <a href="tel:+998700591119" class="flex items-center space-x-3 px-4 py-2 bg-white border border-gray-100 rounded-xl text-blue-900 pointer-events-auto">
                    <span class="text-sm font-black tracking-tight">+998 70 059 11 19</span>
                    <div class="bg-blue-50 p-1.5 rounded-lg text-blue-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                </a>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="mobileMenuOpen" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- BOTTOM BAR (Navigation - Desktop only) -->
    <div class="hidden lg:block bg-white shadow-sm relative z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-10 py-3.5">
                @php
                    $navLinks = [
                        ['route' => 'home', 'label' => __('navbar.menu.home')],
                        ['route' => 'catalog.index', 'label' => __('navbar.menu.catalog')],
                        ['route' => 'news.index', 'label' => __('navbar.menu.news')],
                        ['route' => 'projects.index', 'label' => __('navbar.menu.projects')],
                        ['route' => 'about', 'label' => __('navbar.menu.about')],
                    ];
                @endphp
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route'], ['locale' => app()->getLocale()]) }}" 
                       class="text-sm font-semibold tracking-wide transition-all border-b-2 {{ request()->routeIs($link['route'].'*') ? 'text-blue-600 border-blue-600' : 'text-slate-600 border-transparent hover:text-blue-600 hover:border-blue-200' }} pb-1.5">
                       {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- MOBILE MENU DRAWER (Full Screen) -->
    <div x-show="mobileMenuOpen" 
         class="fixed inset-0 z-[100] lg:hidden" 
         x-cloak
         style="display: none;"
         role="dialog" aria-modal="true">
        
        <!-- Backdrop with blur -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"></div>

        <!-- Menu Body -->
        <div class="fixed inset-0 bg-white flex flex-col transform transition-transform"
             x-transition:enter="transform transition ease-out duration-500" 
             x-transition:enter-start="translate-y-full" 
             x-transition:enter-end="translate-y-0" 
             x-transition:leave="transform transition ease-in duration-400" 
             x-transition:leave-start="translate-y-0" 
             x-transition:leave-end="translate-y-full">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-gray-100 bg-white sticky top-0 z-10">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">
                    <img src="{{ asset('logo/logo.png') }}" alt="TemurMed" class="h-8 w-auto">
                </a>
                <button @click="mobileMenuOpen = false" class="p-2.5 rounded-full bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-all">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content Area -->
            <div class="flex-grow overflow-y-auto px-6 py-8 pb-20 space-y-12 bg-gray-50/30">
                <!-- Nav Links -->
                <nav class="grid grid-cols-2 gap-4">
                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route'], ['locale' => app()->getLocale()]) }}" 
                           class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white shadow-sm border border-gray-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all group">
                           <span class="text-sm font-bold tracking-tight {{ request()->routeIs($link['route'].'*') ? 'text-blue-600' : 'text-gray-900 group-hover:text-blue-600' }}">
                               {{ $link['label'] }}
                           </span>
                        </a>
                    @endforeach
                </nav>

                <!-- Catalog Section (Full Access) -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between px-1">
                        <h3 class="text-lg font-extrabold text-gray-900">{{ __('navbar.middle.catalog') }}</h3>
                        <div class="h-1 flex-grow mx-4 bg-gray-100 rounded-full"></div>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($categories as $category)
                            <a href="{{ route('catalog.category', ['locale' => app()->getLocale(), 'slug' => $category->slug]) }}" 
                               class="flex items-center justify-between p-4 rounded-xl bg-white border border-gray-100 hover:border-blue-300 hover:shadow-md transition-all group">
                                <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-600">{{ $category->name }}</span>
                                <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-600 transform transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Contact & Socials -->
                <div class="pt-8 border-t border-gray-200 space-y-8">
                    <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg">
                        <p class="text-blue-100 text-[10px] font-bold uppercase tracking-widest mb-3">{{ __('navbar.middle.contact_us') }}</p>
                        <div class="flex items-center space-x-4">
                            <div class="bg-white/20 p-2.5 rounded-lg">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <a href="tel:+998700591119" class="text-xl font-bold tracking-tight">+998 70 059 11 19</a>
                        </div>
                    </div>

                    <div class="flex justify-center space-x-8">
                        <a href="https://t.me/Temur_med_manager" class="p-3 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all transform hover:scale-110">
                            <span class="sr-only">Telegram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.11.02-1.93 1.23-5.46 3.62-.51.35-.98.52-1.4.51-.46-.01-1.35-.26-2.01-.48-.81-.27-1.45-.42-1.39-.88.03-.24.37-.48 1.02-.73 4-1.74 6.67-2.88 8-3.41 3.82-1.5 4.61-1.76 5.13-1.77.11 0 .37.03.54.16.14.11.18.27.19.4z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/temurmedtechnical/" class="p-3 rounded-full bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition-all transform hover:scale-110">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
