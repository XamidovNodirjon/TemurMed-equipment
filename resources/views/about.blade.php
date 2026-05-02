@extends('layouts.app')

@section('title', __('About Us'))

@section('content')
<div class="bg-white">
    <!-- Page Header -->
    
    <!-- About Content -->
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Partnership Card -->
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 sm:p-12 mb-10">
                <!-- Main Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-8">
                    {!! __('about.heading') !!}
                </h2>

                <!-- Decorative divider -->
                <div class="flex items-center justify-center mb-8">
                    <div class="h-px w-12 bg-gray-300"></div>
                    <div class="mx-3">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="h-px w-12 bg-gray-300"></div>
                </div>

                <!-- Content paragraphs -->
                <div class="space-y-6 text-center max-w-2xl mx-auto">
                    <p class="text-lg text-gray-700 leading-relaxed font-medium">
                        {!! __('about.p1') !!}
                    </p>

                    <p class="text-base text-gray-600 leading-relaxed">
                        {{ __('about.p2') }}
                    </p>

                    <p class="text-base text-gray-800 leading-relaxed font-semibold">
                        {{ __('about.p3') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
