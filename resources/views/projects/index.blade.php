@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <div class="bg-white pt-10 sm:pt-14 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight border-l-4 border-red-600 pl-4">
                {{ __('projects.index.title') }}
            </h1>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="bg-gray-50 py-10 pb-20 sm:py-14 sm:pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($projects as $item)
                    <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                        <!-- Image -->
                        <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'slug' => $item->slug]) }}"
                           class="relative block h-52 sm:h-56 overflow-hidden">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholder.png') }}"
                                 alt="{{ $item->name }}">
                            <!-- Date badge -->
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center text-xs font-semibold text-white bg-red-600/90 backdrop-blur-sm rounded px-3 py-1 shadow-sm">
                                    {{ $item->published_at ? $item->published_at->format('d.m.Y') : '' }}
                                </span>
                            </div>
                        </a>

                        <!-- Content -->
                        <div class="flex-1 p-5 sm:p-6 flex flex-col">
                            <!-- Title -->
                            <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'slug' => $item->slug]) }}"
                               class="block">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors mb-3 line-clamp-3">
                                    {{ $item->name }}
                                </h3>
                            </a>

                            <!-- Description -->
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-4 flex-1 mb-4">
                                {{ Str::limit(strip_tags($item->description), 200) }}
                            </p>

                            <!-- Footer: Views + Read More -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center text-xs text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>{{ $item->views_count ?? 0 }}</span>
                                </div>
                                <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'slug' => $item->slug]) }}"
                                   class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                                    {{ __('projects.index.read_more') }}
                                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
            <div class="mt-10">
                {{ $projects->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection
