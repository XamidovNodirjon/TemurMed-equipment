@extends('layouts.app')

@section('content')
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                {{-- Breadcrumbs or Back Link --}}
                <div class="mb-6">
                    <a href="{{ route('news.index', ['locale' => app()->getLocale()]) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        {{ __('news.show.back') }}
                    </a>
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        {{ $news->title }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ $news->published_at ? $news->published_at->format('F d, Y') : '' }}
                    </p>
                </div>

                @if($news->image)
                    <div class="mb-12"> <!-- Increased bottom margin from mb-8 to mb-12 -->
                        <img class="w-full h-auto rounded-lg shadow-lg object-cover" src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
                    </div>
                @endif

                <div class="prose prose-blue prose-lg text-gray-500 mx-auto">
                    {!! $news->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
