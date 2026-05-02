<aside class="space-y-8">
    <div>
        <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 mb-6 flex items-center">
            <span class="w-8 h-1 bg-blue-600 mr-3 rounded-full"></span>
            {{ __('catalog.categories') ?? 'Kategoriyalar' }}
        </h3>
        <div class="space-y-1">
            @foreach($categories as $cat)
                @php
                    $isActive = (isset($category) && $category->id == $cat->id) || (isset($product) && $product->category_id == $cat->id);
                @endphp
                <a href="{{ route('catalog.category', ['locale' => app()->getLocale(), 'slug' => $cat->slug]) }}" 
                   class="group flex items-center justify-between p-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-gray-600 hover:bg-white hover:shadow-md hover:text-blue-600' }}">
                    <span class="text-sm font-bold">{{ $cat->name }}</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Contact Card -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
        </div>
        <h4 class="text-xl font-black mb-4 leading-tight">Yordam kerakmi?</h4>
        <p class="text-blue-100 text-sm mb-6 leading-relaxed">Mutaxassislarimiz sizga mahsulot tanlashda yordam berishga tayyor.</p>
        <a href="tel:+998901234567" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors">
            Bog'lanish
        </a>
    </div>
</aside>
