@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
                <!-- Image Gallery -->
                <div class="flex flex-col-reverse">
                    <div class="w-full aspect-w-1 aspect-h-1">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600' }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover rounded-lg sm:rounded-lg">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>

                    <div class="mt-3">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl text-blue-600">
                            @if($product->price)
                                ${{ number_format($product->price, 2) }}
                            @else
                                Contact for Price
                            @endif
                        </p>
                    </div>

                    <div class="mt-6">
                        <h3 class="sr-only">Description</h3>
                        <div class="text-base text-gray-700 space-y-6">
                            {!! $product->description !!}
                        </div>
                    </div>

                    <!-- Specifications -->
                    @if($product->specifications)
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h3 class="text-lg font-medium text-gray-900">Specifications</h3>
                            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                @foreach($product->specifications as $key => $value)
                                    <div class="border-t border-gray-200 pt-4">
                                        <dt class="font-medium text-gray-900">{{ $key }}</dt>
                                        <dd class="mt-2 text-sm text-gray-500">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    @endif

                    <div class="mt-10">
                        <button type="button" class="w-full bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Order / Application
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <section class="mt-16 border-t border-gray-200 pt-10">
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Related Products</h2>
                    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                         @foreach($relatedProducts as $related)
                            <div class="group relative">
                                <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
                                    <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://via.placeholder.com/300' }}" alt="{{ $related->name }}" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <h3 class="text-sm text-gray-700">
                                            <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $related->slug]) }}">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{ $related->name }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
@endsection
