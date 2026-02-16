@extends('layouts.app')

@section('content')
    <!-- Hero Section (Dynamic Slider) -->
    <div x-data="{ 
        activeSlide: 0, 
        slides: {{ $sliders->map(fn($s) => ['image' => asset('storage/' . $s->image), 'title' => $s->title, 'subtitle' => $s->subtitle, 'link' => $s->link])->toJson() }},
        autoplayInterval: null,
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        },
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
        },
        startAutoplay() {
            this.autoplayInterval = setInterval(() => this.next(), 5000);
        },
        stopAutoplay() {
            clearInterval(this.autoplayInterval);
        }
    }" 
    x-init="startAutoplay()" 
    @mouseenter="stopAutoplay()" 
    @mouseleave="startAutoplay()"
    class="relative bg-gray-900 overflow-hidden h-[500px] sm:h-[600px] lg:h-[700px]">
        
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 w-full h-full">
                
                <!-- Image -->
                <img :src="slide.image" :alt="slide.title" class="absolute inset-0 w-full h-full object-cover opacity-60">
                
                <!-- Overlay (Gradient) -->
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/40 to-transparent"></div>

                <!-- Content -->
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
                    <div class="max-w-2xl text-white pt-16">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight mb-4 leading-tight" x-text="slide.title"></h1>
                        <p class="text-lg sm:text-xl md:text-2xl text-gray-200 mb-8 max-w-lg" x-text="slide.subtitle"></p>
                        
                        <div class="flex flex-wrap gap-4">
                            <!-- View Catalog Button (Opens Modal) -->
                            <button @click="$dispatch('open-catalog-modal')" 
                                    class="px-8 py-3 bg-blue-600 border border-transparent rounded-full text-white text-base font-semibold hover:bg-blue-700 md:py-4 md:text-lg md:px-10 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                {{ __('home.hero.view_catalog') }}
                            </button>
                            
                            <!-- Optional Link Button -->
                            <template x-if="slide.link">
                                <a :href="slide.link" class="px-8 py-3 bg-transparent border-2 border-white rounded-full text-white text-base font-semibold hover:bg-white hover:text-gray-900 md:py-4 md:text-lg md:px-10 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-1">
                                    {{ __('home.hero.learn_more') }}
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Arrows -->
        <button @click="prev()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-3 rounded-full transition-all border border-white/20 hidden sm:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-3 rounded-full transition-all border border-white/20 hidden sm:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-8 left-0 right-0 flex justify-center space-x-3">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="h-1.5 rounded-full transition-all duration-300"
                        :class="activeSlide === index ? 'bg-white w-8' : 'bg-white/40 w-4 hover:bg-white/60'">
                </button>
            </template>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Feature 1: High Quality -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-8 text-center group">
                    <div class="inline-flex items-center justify-center p-4 bg-orange-50 text-orange-600 rounded-full mb-6 group-hover:bg-orange-100 transition-colors">
                        <!-- Heroicon name: outline/badge-check -->
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('home.features.quality') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed px-2">
                        {{ __('home.features.quality_desc') }}
                    </p>
                </div>

                <!-- Feature 2: Factory Advantage -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-8 text-center group">
                    <div class="inline-flex items-center justify-center p-4 bg-orange-50 text-orange-600 rounded-full mb-6 group-hover:bg-orange-100 transition-colors">
                        <!-- Heroicon name: outline/office-building -->
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('home.features.factory') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed px-2">
                        {{ __('home.features.factory_desc') }}
                    </p>
                </div>

                <!-- Feature 3: Years of Experience -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-8 text-center group">
                    <div class="inline-flex items-center justify-center p-4 bg-orange-50 text-orange-600 rounded-full mb-6 group-hover:bg-orange-100 transition-colors">
                        <!-- Heroicon name: outline/briefcase -->
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.220-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('home.features.experience') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed px-2">
                        {{ __('home.features.experience_desc') }}
                    </p>
                </div>

                <!-- Feature 4: Customer Orientation -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-8 text-center group">
                    <div class="inline-flex items-center justify-center p-4 bg-orange-50 text-orange-600 rounded-full mb-6 group-hover:bg-orange-100 transition-colors">
                        <!-- Heroicon name: outline/user-group -->
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('home.features.customer') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed px-2">
                        {{ __('home.features.customer_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </div>



    <!-- Recommended Products Section -->
    @if($recommendedProducts->count() > 0)
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">{{ __('home.recommended.title') }}</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    {{ __('home.recommended.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                @foreach($recommendedProducts as $product)
                    <div class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-60">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-center object-contain sm:w-full sm:h-full p-4">
                        </div>
                        <div class="flex-1 p-4 space-y-2 flex flex-col">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ strip_tags($product->description) }}</p>
                            <div class="flex-1 flex flex-col justify-end">
                                <p class="text-base font-medium text-gray-900">
                                    {{ $product->price ? '$' . number_format($product->price, 2) : __('home.recommended.contact_price') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
             <div class="mt-10 text-center">
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    {{ __('home.recommended.view_all') }}
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Latest News Section -->
    @if($latestNews->count() > 0)
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">{{ __('home.news.title') }}</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    {{ __('home.news.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                @foreach($latestNews as $news)
                    <div class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-3 aspect-h-2 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-40">
                            <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/placeholder.png') }}"
                                 alt="{{ $news->title }}"
                                 class="w-full h-full object-center object-cover">
                        </div>
                        <div class="flex-1 p-4 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-medium text-blue-600">
                                    {{ $news->published_at ? $news->published_at->format('M d, Y') : '' }}
                                </p>
                                <a href="{{ route('news.show', $news->slug) }}" class="block mt-2">
                                    <p class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $news->title }}</p>
                                    <p class="mt-2 text-xs text-gray-500 line-clamp-3">{{ Str::limit(strip_tags($news->content), 80) }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('news.index') }}" class="inline-flex items-center px-4 py-2 border border-blue-600 text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                    {{ __('home.news.view_all') }}
                </a>
            </div>
        </div>
    </div>
    @endif
    <!-- Featured Categories removed -->
    <!-- View Catalog Modal -->
    <div x-data="{ open: false }"
         @open-catalog-modal.window="open = true"
         x-show="open"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         style="display: none;">
        
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="open = false"
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Heroicon name: outline/book-open -->
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ __('home.modal.title') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ __('home.modal.desc') }}
                                </p>
                                
                                <form action="#" method="POST" class="mt-4 space-y-4" @submit.prevent="alert('Submitted! (Placeholder)')">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('home.modal.name') }}</label>
                                        <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('home.modal.phone') }}</label>
                                        <input type="tel" name="phone" id="phone" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                    <div class="py-3 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                            {{ __('home.modal.submit') }}
                                        </button>
                                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            {{ __('home.modal.cancel') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
