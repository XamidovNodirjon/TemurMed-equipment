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

                    <div class="mt-10" x-data="{ showModal: false }" x-init="$watch('showModal', value => document.body.classList.toggle('overflow-hidden', value))">
                        <button @click="showModal = true" type="button" class="w-full bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('application.form.submit') }}
                        </button>

                        <!-- Modal -->
                        <div x-show="showModal" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                            <div x-show="showModal" 
                                 x-transition:enter="ease-out duration-300" 
                                 x-transition:enter-start="opacity-0" 
                                 x-transition:enter-end="opacity-100" 
                                 x-transition:leave="ease-in duration-200" 
                                 x-transition:leave-start="opacity-100" 
                                 x-transition:leave-end="opacity-0" 
                                 class="fixed inset-0 bg-gray-600 bg-opacity-40 transition-opacity backdrop-blur-sm" 
                                 aria-hidden="true"></div>

                            <div class="fixed inset-0 z-[100] overflow-y-auto">
                                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                                    <div x-show="showModal" 
                                         x-transition:enter="ease-out duration-300" 
                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                         x-transition:leave="ease-in duration-200" 
                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                         class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                                         @click.away="showModal = false">
                                        
                                        <div x-data="{ 
                                            formData: {
                                                name: '',
                                                phone: '',
                                                message: '',
                                                product_id: '{{ $product->id }}',
                                                locale: '{{ app()->getLocale() }}',
                                                _token: '{{ csrf_token() }}'
                                            },
                                            loading: false,
                                            success: false,
                                            submitForm() {
                                                this.loading = true;
                                                fetch('{{ route('application.store', ['locale' => app()->getLocale()]) }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                        'Accept': 'application/json'
                                                    },
                                                    body: JSON.stringify(this.formData)
                                                })
                                                .then(response => {
                                                    if (response.ok) {
                                                        this.success = true;
                                                        this.formData.name = '';
                                                        this.formData.phone = '';
                                                        this.formData.message = '';
                                                        setTimeout(() => {
                                                            this.showModal = false;
                                                            this.success = false;
                                                        }, 3000);
                                                    } else {
                                                        alert('Error submitting application. Please try again.');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                    alert('An error occurred. Please try again.');
                                                })
                                                .finally(() => {
                                                    this.loading = false;
                                                });
                                            }
                                        }">
                                            <div x-show="success" class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                            {{ __('application.submitted_successfully') }}
                                                        </h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-500">
                                                                {{ __('application.submitted_successfully') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <form x-show="!success" @submit.prevent="submitForm">
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                                {{ __('application.form.title') }}
                                                            </h3>
                                                            <div class="mt-4 space-y-4">
                                                                <div>
                                                                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('application.form.name') }}</label>
                                                                    <input type="text" x-model="formData.name" id="name" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md py-2 px-3 border">
                                                                </div>
                                                                <div>
                                                                    <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('application.form.phone') }}</label>
                                                                    <input type="text" x-model="formData.phone" id="phone" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md py-2 px-3 border">
                                                                </div>
                                                                <div>
                                                                    <label for="message" class="block text-sm font-medium text-gray-700">{{ __('application.form.message') }}</label>
                                                                    <textarea x-model="formData.message" id="message" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md py-2 px-3 border"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <button type="submit" :disabled="loading" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                                                        <span x-show="!loading">{{ __('application.form.submit') }}</span>
                                                        <span x-show="loading">...</span>
                                                    </button>
                                                    <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        {{ __('application.form.cancel') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
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
