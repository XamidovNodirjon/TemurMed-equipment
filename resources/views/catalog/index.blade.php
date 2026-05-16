@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Top Bar: Left Breadcrumb, Right Filter -->
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="flex flex-row items-center justify-between gap-4">
                    <!-- Breadcrumb (Left-aligned) -->
                    <nav aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-gray-400">
                            <li><a href="{{ route('home', app()->getLocale()) }}" class="hover:text-blue-900 transition-colors">{{ __('navbar.menu.home') }}</a></li>
                            <li><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg></li>
                            <li><span class="{{ !isset($category) ? 'text-blue-900' : '' }}">{{ __('catalog.breadcrumb') }}</span></li>
                            @if(isset($category))
                                <li><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg></li>
                                <li><span class="text-blue-900">{{ $category->name }}</span></li>
                            @endif
                        </ol>
                    </nav>

                    <!-- Filter (Right-aligned, Small) -->
                    <div class="w-48 sm:w-64" x-data="{ selectedCategory: '{{ isset($category) ? route('catalog.category', ['locale' => app()->getLocale(), 'slug' => $category->slug]) : route('catalog.index', ['locale' => app()->getLocale()]) }}' }">
                        <div class="relative">
                            <select x-model="selectedCategory"
                                    @change="window.location.href = selectedCategory"
                                    class="block w-full appearance-none bg-white border border-gray-200 text-gray-900 text-[10px] sm:text-[11px] font-medium uppercase tracking-widest py-2 px-4 pr-10 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-900 transition-all cursor-pointer hover:border-blue-300">
                                <option value="{{ route('catalog.index', ['locale' => app()->getLocale()]) }}">{{ __('catalog.all_sections') }}</option>
                                @foreach($categories as $cat)
                                    <option value="{{ route('catalog.category', ['locale' => app()->getLocale(), 'slug' => $cat->slug]) }}"
                                            {{ isset($category) && $category->id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Product Grid: Robust Uniform Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($products as $product)
                    <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-500 flex flex-col h-full overflow-hidden">
                        <!-- Image Container (Fixed Height for Robustness) -->
                        <div class="h-64 sm:h-72 w-full bg-white flex items-center justify-center p-6 overflow-hidden">
                            <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $product->slug]) }}" class="w-full h-full flex items-center justify-center">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600' }}" 
                                     alt="{{ $product->name }}" 
                                     class="max-w-full max-h-full object-contain transform group-hover:scale-105 transition-transform duration-700">
                            </a>
                        </div>

                        <!-- Info Area -->
                        <div class="p-6 flex flex-col flex-grow text-center">
                            <h3 class="text-sm font-semibold text-gray-900 leading-snug flex-grow line-clamp-2 h-10">
                                <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $product->slug]) }}" class="hover:text-blue-900 transition-colors">
                                    {{ $product->name }}
                                </a>
                            </h3>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center">
                        <h3 class="text-xl font-bold text-gray-900">{{ __('catalog.no_products') }}</h3>
                        <a href="{{ route('catalog.index', app()->getLocale()) }}" class="mt-4 inline-block text-[#00b4a2] font-bold hover:underline">{{ __('catalog.back_to_catalog') }}</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $products->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </main>
    </div>
@endsection
