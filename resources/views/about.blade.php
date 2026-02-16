@extends('layouts.app')

@section('title', __('About Us'))

@section('content')
<div class="bg-white flex items-center justify-center min-h-[60vh] pt-88 pb-16 sm:pt-64 sm:pb-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center" style="margin-top: 55px;">
        <!-- Main Title (Partnership) -->
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-8 font-sans tracking-tight">
            {!! __('about.heading') !!}
        </h1>

        <!-- Content Body -->
        <div class="prose prose-lg prose-blue mx-auto text-gray-600 leading-relaxed">
            <p class="mb-8 text-xl text-gray-700">
                {!! __('about.p1') !!}
            </p>
            
            <p class="mb-8">
                {{ __('about.p2') }}
            </p>

            <p class="mb-10 font-medium text-gray-800">
                {{ __('about.p3') }}
            </p>
        </div>
    </div>
</div>
@endsection
