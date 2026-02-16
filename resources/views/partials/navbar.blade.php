<div class="flex flex-col font-sans text-gray-900">
    <!-- TOP BAR -->
    <div class="bg-slate-900 text-white text-xs py-2 relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <a href="tel:+998700501119" class="flex items-center hover:text-gray-300">
                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    +998 70 050 11 19
                </a>
                <div class="flex items-center">
                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Mon-Sat: 9:00 - 18:00
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://t.me/Temur_med_manager" class="hover:text-gray-300">{{ __('navbar.top.telegram') }}</a>
                <a href="https://www.instagram.com/temurmedtechnical/" class="hover:text-gray-300">{{ __('navbar.top.instagram') }}</a>
                
                <!-- Language Dropdown -->
                <div class="relative ml-4" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center text-gray-300 hover:text-white transition-colors focus:outline-none px-3 py-1.5 rounded-md hover:bg-slate-700">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="uppercase font-medium">{{ app()->getLocale() }}</span>
                        <svg class="h-3 w-3 ml-1 transform transition-transform text-gray-400" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" 
                         class="absolute right-0 mt-2 w-32 bg-white text-gray-800 rounded-md shadow-xl z-50 py-2 border border-gray-100 transform origin-top-right" 
                         x-cloak 
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                         
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100 mb-1">
                            {{ __('navbar.top.language') }}
                        </div>

                        <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'uz'])) }}" 
                           @click="open = false" 
                           class="flex items-center px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ app()->getLocale() == 'uz' ? 'bg-blue-50 text-blue-600 font-bold' : '' }}">
                           <span class="w-6 text-center text-sm mr-2">🇺🇿</span>
                           <span>O'zbek</span>
                           @if(app()->getLocale() == 'uz')
                               <svg class="w-4 h-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                               </svg>
                           @endif
                        </a>
                        <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'ru'])) }}" 
                           @click="open = false" 
                           class="flex items-center px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ app()->getLocale() == 'ru' ? 'bg-blue-50 text-blue-600 font-bold' : '' }}">
                           <span class="w-6 text-center text-sm mr-2">🇷🇺</span>
                           <span>Русский</span>
                           @if(app()->getLocale() == 'ru')
                               <svg class="w-4 h-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                               </svg>
                           @endif
                        </a>
                        <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}" 
                           @click="open = false" 
                           class="flex items-center px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ app()->getLocale() == 'en' ? 'bg-blue-50 text-blue-600 font-bold' : '' }}">
                           <span class="w-6 text-center text-sm mr-2">🇬🇧</span>
                           <span>English</span>
                           @if(app()->getLocale() == 'en')
                               <svg class="w-4 h-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                               </svg>
                           @endif
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

            <!-- Catalog & Search -->
            <div class="flex-1 max-w-3xl flex items-center gap-2 relative">
                <!-- Catalog Dropdown -->
                <div x-data="{ open: false, activeCategory: null }" class="relative">
                    <button @click="open = !open" @click.away="open = false; activeCategory = null" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        {{ __('navbar.middle.catalog') }}
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         class="absolute top-full left-0 mt-2 w-[600px] bg-white rounded-md shadow-xl border border-gray-100 flex overflow-hidden max-h-[500px]" 
                         x-cloak
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translateY-2"
                         x-transition:enter-end="opacity-100 translateY-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translateY-0"
                         x-transition:leave-end="opacity-0 translateY-2">
                        
                        <!-- Categories List (Left) -->
                        <div class="w-1/3 bg-gray-50 border-r border-gray-100 overflow-y-auto">
                            <ul class="py-2">
                                @foreach($categories as $category)
                                    <li @mouseenter="activeCategory = {{ $category->id }}">
                                        <a href="{{ route('catalog.category', ['locale' => app()->getLocale(), 'slug' => $category->slug]) }}" 
                                           class="flex items-center justify-between px-4 py-3 text-sm text-gray-700 hover:bg-white hover:text-blue-600 transition-colors cursor-pointer border-l-4 border-transparent hover:border-blue-600"
                                           :class="{'bg-white text-blue-600 border-blue-600': activeCategory == {{ $category->id }}}">
                                            <span>{{ $category->name }}</span>
                                            <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Subcategories Panel (Right) -->
                        <div class="w-2/3 bg-white p-6 overflow-y-auto">
                            @foreach($categories as $category)
                                <div x-show="activeCategory == {{ $category->id }}" style="display: none;">
                                    <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">{{ $category->name }}</h3>
                                    @if($category->subCategories->count() > 0)
                                        <div class="grid grid-cols-2 gap-4">
                                            @foreach($category->subCategories as $subCategory)
                                                <a href="#" class="text-sm text-gray-600 hover:text-blue-600 hover:underline">
                                                    {{ $subCategory->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-400">{{ __('navbar.middle.no_subcategories') }}</p>
                                    @endif
                                </div>
                            @endforeach
                            
                            <!-- Default State -->
                            <div x-show="!activeCategory" class="flex flex-col items-center justify-center h-full text-gray-400">
                                <svg class="h-16 w-16 mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <p>{{ __('navbar.middle.hover_details') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="flex-1 relative">
                    <input type="text" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm pl-4 pr-10 py-2.5" placeholder="{{ __('navbar.middle.search_placeholder') }}">
                    <button class="absolute inset-y-0 right-0 pr-3 flex items-center hover:text-blue-600">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-6">
                <a href="#" class="group flex flex-col items-center text-gray-500 hover:text-blue-600 transition-colors">
                    <svg class="h-6 w-6 mb-1 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="text-xs font-medium">{{ __('navbar.middle.favorites') }}</span>
                </a>
                <a href="tel:+998700501119" class="group flex flex-col items-center text-gray-500 hover:text-blue-600 transition-colors">
                    <svg class="h-6 w-6 mb-1 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="text-xs font-medium">{{ __('navbar.middle.contact') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- BOTTOM BAR (Navigation) -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-8 py-3">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                   class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-red-600' : 'text-blue-900 hover:text-red-600' }}">
                   {{ __('navbar.menu.home') }}
                </a>
                <a href="{{ route('catalog.index', ['locale' => app()->getLocale()]) }}" 
                   class="text-sm font-medium transition-colors {{ request()->routeIs('catalog.*') ? 'text-red-600' : 'text-blue-900 hover:text-red-600' }}">
                   {{ __('navbar.menu.catalog') }}
                </a>
                <a href="{{ route('news.index', ['locale' => app()->getLocale()]) }}" 
                   class="text-sm font-medium transition-colors {{ request()->routeIs('news.*') ? 'text-red-600' : 'text-blue-900 hover:text-red-600' }}">
                   {{ __('navbar.menu.news') }}
                </a>
                <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" 
                   class="text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'text-red-600' : 'text-blue-900 hover:text-red-600' }}">
                   {{ __('navbar.menu.about') }}
                </a>
                <a href="#" 
                   class="text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'text-red-600' : 'text-blue-900 hover:text-red-600' }}">
                   {{ __('navbar.menu.contact') }}
                </a>
            </div>
        </div>
    </div>
</div>
