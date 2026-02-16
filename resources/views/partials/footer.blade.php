<footer class="bg-slate-900 text-white pt-16 pb-8 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <!-- Brand & Description -->
            <div class="col-span-1 space-y-6">
                <a href="{{ route('home') }}" class="block">
                    <img src="{{ asset('logo/logo.png') }}" alt="TemurMed" class="h-12 w-auto brightness-0 invert">
                </a>
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                    {{ __('footer.description') }}
                </p>
                
                <div class="flex space-x-3 pt-2">
                    <!-- Telegram -->
                    <a href="https://t.me/temurmed" class="bg-gray-800 hover:bg-blue-600 w-10 h-10 flex items-center justify-center rounded transition-all duration-300 group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                    </a>
                    <!-- Instagram -->
                    <a href="https://instagram.com/temurmed" class="bg-gray-800 hover:bg-pink-600 w-10 h-10 flex items-center justify-center rounded transition-all duration-300 group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-8 3.999 3.999 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    </a>
                     <!-- Facebook (Placeholder) -->
                     <a href="#" class="bg-gray-800 hover:bg-blue-800 w-10 h-10 flex items-center justify-center rounded transition-all duration-300 group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                </div>
            </div>

            <!-- SECTIONS -->
            <div class="col-span-1">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-8">{{ __('footer.sections') }}</h3>
                <ul class="space-y-4">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors text-sm uppercase tracking-wide block">{{ __('footer.links.home') }}</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="text-gray-400 hover:text-white transition-colors text-sm uppercase tracking-wide block">{{ __('footer.links.catalog') }}</a></li>
                    <li><a href="{{ route('news.index') }}" class="text-gray-400 hover:text-white transition-colors text-sm uppercase tracking-wide block">{{ __('footer.links.news') }}</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors text-sm uppercase tracking-wide block">{{ __('footer.links.about') }}</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm uppercase tracking-wide block">{{ __('footer.links.contact') }}</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm uppercase tracking-wide block">{{ __('footer.links.delivery') }}</a></li>
                </ul>
            </div>

            <!-- CONTACTS -->
            <div class="col-span-1">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-8">{{ __('footer.contacts.title') }}</h3>
                <ul class="space-y-6">
                    <li class="flex items-start group">
                        <div class="bg-gray-800 p-2 rounded mr-4 group-hover:bg-blue-900 transition-colors shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-gray-400 text-sm leading-relaxed block">{{ __('footer.contacts.address') }}</span>
                    </li>
                    <li class="flex items-start group">
                         <div class="bg-gray-800 p-2 rounded mr-4 group-hover:bg-blue-900 transition-colors shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-400 text-sm hover:text-white transition-colors block">+998 70 050 11 19</span>
                            <span class="text-gray-400 text-sm hover:text-white transition-colors block">+998 78 129 09 90</span>
                        </div>
                    </li>
                    <li class="flex items-start group">
                         <div class="bg-gray-800 p-2 rounded mr-4 group-hover:bg-blue-900 transition-colors shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-gray-400 text-sm hover:text-white transition-colors block">info@temurmed.uz</span>
                    </li>
                </ul>
            </div>
            
             <!-- Catalog Button -->
            <div class="col-span-1">
                 <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-8">{{ __('footer.products') }}</h3>
                 <p class="text-gray-400 text-sm mb-6 max-w-xs">
                     {{ __('footer.catalog_desc') }}
                 </p>
                 <a href="{{ route('catalog.index') }}" class="w-full sm:w-auto flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    {{ __('footer.open_catalog') }}
                 </a>
            </div>
        </div>
