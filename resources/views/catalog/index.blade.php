@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="py-4 bg-gray-100">
            <ol role="list" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-2">
                <li>
                    <a href="{{ route('home', app()->getLocale()) }}" class="text-gray-500 hover:text-gray-900">Home</a>
                </li>
                <li>
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                </li>
                <li>
                    <span class="text-gray-900 font-medium">{{ isset($category) ? $category->name : 'Catalog' }}</span>
                </li>
            </ol>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-x-8">
                <!-- Sidebar -->
                <aside class="hidden lg:block space-y-4">
                    <h3 class="text-lg font-bold text-gray-900">Categories</h3>
                    <div class="space-y-2">
                        @foreach($categories as $cat)
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-left text-gray-600 hover:text-blue-600">
                                    <span class="font-medium">{{ $cat->name }}</span>
                                    <svg class="h-5 w-5 transform transition-transform" :class="{'rotate-180': open}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" class="ml-4 mt-2 space-y-1" x-cloak>
                                    @foreach($cat->subCategories as $sub)
                                        <a href="#" class="block text-sm text-gray-500 hover:text-blue-600">
                                            {{ $sub->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </aside>

                <!-- Product Grid -->
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-64">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover sm:w-full sm:h-full">
                                </div>
                                <div class="flex-1 p-4 space-y-2 flex flex-col">
                                    <h3 class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $product->slug]) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500 line-clamp-2">{{ strip_tags($product->description) }}</p>
                                    <div class="flex-1 flex flex-col justify-end">
                                        <p class="text-lg font-bold text-blue-600">
                                            @if($product->price)
                                                ${{ number_format($product->price, 2) }}
                                            @else
                                                Contact for Price
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500">No products found.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
