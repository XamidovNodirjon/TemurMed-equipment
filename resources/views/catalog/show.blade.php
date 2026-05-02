@extends('layouts.app')

@section('content')
    <div class="bg-white min-h-screen">
        <!-- Top Bar: Breadcrumb -->
        <div class="bg-gray-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                        <li><a href="{{ route('home', app()->getLocale()) }}" class="hover:text-blue-900 transition-colors">Bosh sahifa</a></li>
                        <li><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg></li>
                        <li><a href="{{ route('catalog.index', app()->getLocale()) }}" class="hover:text-blue-900 transition-colors">Katalog</a></li>
                        <li><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg></li>
                        <li><span class="text-blue-900 truncate">{{ $product->name }}</span></li>
                    </ol>
                </nav>
            </div>
        </div>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col lg:flex-row gap-12 xl:gap-16">
                
                <!-- Left Column: Image Gallery -->
                <div class="w-full lg:w-1/2" 
                     x-data="{ 
                        mainImage: '{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/800x600' }}',
                        images: [
                            '{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/800x600' }}',
                            @if($product->images)
                                @foreach($product->images as $img) '{{ asset('storage/' . $img) }}', @endforeach
                            @endif
                        ],
                        currentIndex: 0,
                        next() {
                            this.currentIndex = (this.currentIndex + 1) % this.images.length;
                            this.mainImage = this.images[this.currentIndex];
                        },
                        prev() {
                            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                            this.mainImage = this.images[this.currentIndex];
                        },
                        set(index) {
                            this.currentIndex = index;
                            this.mainImage = this.images[index];
                        }
                     }">
                    
                    <!-- Main Image Display -->
                    <div class="relative group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm ring-1 ring-black/5">
                        <div class="aspect-w-4 aspect-h-3 sm:aspect-none sm:h-[500px] flex items-center justify-center p-6 sm:p-12">
                            <img :src="mainImage" 
                                 alt="{{ $product->name }}" 
                                 class="max-w-full max-h-full object-contain transition-all duration-500 transform group-hover:scale-105">
                        </div>

                        <!-- Navigation Arrows -->
                        <template x-if="images.length > 1">
                            <div class="absolute inset-0 flex items-center justify-between px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button @click="prev()" class="p-3 rounded-full bg-white/90 backdrop-blur-sm text-blue-900 shadow-xl hover:bg-blue-900 hover:text-white transition-all transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                                </button>
                                <button @click="next()" class="p-3 rounded-full bg-white/90 backdrop-blur-sm text-blue-900 shadow-xl hover:bg-blue-900 hover:text-white transition-all transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                                </button>
                            </div>
                        </template>

                        <!-- Counter -->
                        <div class="absolute bottom-6 right-6">
                            <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur-md text-blue-900 text-[10px] font-black uppercase tracking-widest shadow-sm ring-1 ring-black/5">
                                <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Thumbnails List -->
                    <template x-if="images.length > 1">
                        <div class="mt-8 flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                            <template x-for="(img, index) in images" :key="index">
                                <button @click="set(index)" 
                                        class="flex-shrink-0 w-24 h-24 bg-white rounded-2xl overflow-hidden border-2 transition-all duration-300 transform hover:scale-105"
                                        :class="currentIndex === index ? 'border-blue-900 ring-4 ring-blue-900/10' : 'border-gray-100 hover:border-gray-200'">
                                    <img :src="img" class="w-full h-full object-contain p-3">
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Right Column: Product Info -->
                <div class="w-full lg:w-1/2 flex flex-col">
                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-900 text-[10px] font-black uppercase tracking-[0.2em] rounded-md">
                                {{ $product->category->name ?? 'Uskuna' }}
                            </span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight uppercase tracking-tight mb-6">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <div class="prose prose-blue prose-sm sm:prose-base max-w-none text-gray-600 leading-relaxed mb-10">
                        {!! $product->description !!}
                    </div>



                    <!-- CTA Button Section -->
                    <div class="mt-auto" x-data="{ showModal: false }">
                        <button @click="showModal = true" 
                                class="w-full sm:w-auto inline-flex items-center justify-center px-12 py-5 bg-blue-900 text-white text-base font-black rounded-2xl hover:bg-black transition-all transform hover:-translate-y-1 shadow-2xl shadow-blue-900/20 uppercase tracking-widest group">
                            <svg class="w-6 h-6 mr-3 text-blue-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                            Ariza yuborish
                        </button>

                        <!-- Modal -->
                        @include('partials.application_modal')
                    </div>
                </div>
            </div>



            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <section class="mt-32">
                    <div class="flex items-center justify-between mb-12">
                        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-widest">O'xshash mahsulotlar</h2>
                        <a href="{{ route('catalog.index', app()->getLocale()) }}" class="text-[10px] font-black text-blue-900 uppercase tracking-widest hover:underline">Barchasini ko'rish</a>
                    </div>
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                         @foreach($relatedProducts as $related)
                            <div class="group relative bg-white rounded-3xl overflow-hidden border border-gray-50 hover:shadow-2xl transition-all duration-500">
                                <div class="aspect-w-1 aspect-h-1 bg-white overflow-hidden p-6">
                                    <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://via.placeholder.com/400' }}" 
                                         alt="{{ $related->name }}" 
                                         class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div class="p-6 text-center border-t border-gray-50">
                                    <h3 class="text-xs font-bold text-gray-900 group-hover:text-blue-900 transition-colors line-clamp-2 mb-2 h-10">
                                        <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $related->slug]) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $related->name }}
                                        </a>
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
@endsection
