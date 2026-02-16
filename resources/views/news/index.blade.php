@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    {{ __('news.index.title') }}
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    {{ __('news.index.subtitle') }}
                </p>
            </div>
            <div class="mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
                @foreach($news as $item)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                        <div class="flex-shrink-0">
                            <img class="h-48 w-full object-cover" src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholder.png') }}" alt="{{ $item->title }}">
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <a href="{{ route('news.show', ['locale' => app()->getLocale(), 'slug' => $item->slug]) }}" class="block mt-2">
                                    <p class="text-xl font-semibold text-gray-900">
                                        {{ $item->title }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                        {{ Str::limit(strip_tags($item->content), 200) }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="sr-only">{{ __('news.index.published_on') }}</span>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $item->published_at ? $item->published_at->format('M d, Y') : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection
