@extends('layouts.app')

@section('title', $news->title)

@push('styles')
    <style>
        /* Article prose styles */
        .news-prose {
            font-size: 1.0625rem;
            line-height: 1.85;
            color: #374151;
        }

        .news-prose p {
            margin-bottom: 1.5em;
        }

        .news-prose h2,
        .news-prose h3,
        .news-prose h4 {
            font-family: 'Instrument Sans', system-ui, -apple-system, sans-serif;
            font-weight: 700;
            color: #111827;
            margin-top: 2em;
            margin-bottom: 0.75em;
            line-height: 1.3;
        }

        .news-prose h2 {
            font-size: 1.5em;
        }

        .news-prose h3 {
            font-size: 1.25em;
        }

        .news-prose img {
            border-radius: 12px;
            margin: 2em auto;
            max-width: 100%;
            height: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .news-prose a {
            color: #2563eb;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .news-prose a:hover {
            color: #1d4ed8;
        }

        .news-prose ul,
        .news-prose ol {
            margin-bottom: 1.5em;
            padding-left: 1.5em;
        }

        .news-prose li {
            margin-bottom: 0.5em;
        }

        .news-prose blockquote {
            border-left: 4px solid #2563eb;
            padding: 1em 1.5em;
            margin: 2em 0;
            background: #f8fafc;
            border-radius: 0 8px 8px 0;
            font-style: italic;
            color: #475569;
        }

        .news-prose strong {
            font-weight: 700;
            color: #1e293b;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16">

            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('news.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-red-700 hover:text-red-800 font-medium text-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('news.show.back') }}
                </a>
            </div>

            <!-- Image (centered, with date badge) -->
            @if($news->image)
                <div class="relative w-full rounded-lg overflow-hidden mb-8">
                    <img src="{{ asset('storage/' . $news->image) }}"
                         alt="{{ $news->title }}"
                         class="w-full h-auto object-cover rounded-lg"
                         style="max-height: 480px;">
                    <!-- Date badge on image -->
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center text-xs font-semibold text-white bg-red-600/90 backdrop-blur-sm rounded px-3 py-1.5 shadow-sm">
                            {{ $news->published_at ? $news->published_at->format('d.m.Y') : $news->created_at->format('d.m.Y') }}
                        </span>
                    </div>
                </div>
            @endif

            <!-- Date & Views -->
            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-5">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $news->published_at ? $news->published_at->format('d.m.Y') : $news->created_at->format('d.m.Y') }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>{{ $news->views_count ?? 0 }}</span>
                </div>
            </div>

            <!-- Title (Name) -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-8">
                {{ $news->title }}
            </h1>

            <!-- Content (Description) -->
            <article class="news-prose">
                {!! $news->content !!}
            </article>
        </div>
    </div>
@endsection
