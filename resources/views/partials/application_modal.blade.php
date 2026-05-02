<div x-show="showModal" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <div x-show="showModal" 
         x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-gray-900/60 transition-opacity backdrop-blur-md" 
         aria-hidden="true"></div>

    <div class="fixed inset-0 z-[100] overflow-y-auto">
        <div class="flex min-h-full items-start justify-center p-4 text-center sm:p-0 sm:items-center">
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                 @click.away="showModal = false">
                
                <div x-data="{ 
                    formData: {
                        name: '',
                        phone: '',
                        message: '',
                        product_id: '{{ $product->id ?? '' }}',
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
                                    showModal = false;
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
                    <!-- Success Message -->
                    <div x-show="success" class="p-8 text-center">
                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                            <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">
                            Muvaffaqiyatli yuborildi!
                        </h3>
                        <p class="text-gray-500">
                            Tez orada mutaxassislarimiz siz bilan bog'lanishadi.
                        </p>
                    </div>

                    <!-- Form -->
                    <form x-show="!success" @submit.prevent="submitForm">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl font-bold text-gray-900">Ariza qoldirish</h3>
                                <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Ismingiz</label>
                                    <input type="text" x-model="formData.name" required 
                                           placeholder="Masalan: Aziz"
                                           class="w-full bg-gray-50 border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none border">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Telefon raqamingiz</label>
                                    <input type="text" x-model="formData.phone" required 
                                           placeholder="+998 90 123 45 67"
                                           class="w-full bg-gray-50 border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none border">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Xabaringiz (ixtiyoriy)</label>
                                    <textarea x-model="formData.message" rows="3" 
                                              placeholder="Qo'shimcha savollaringiz bo'lsa yozib qoldiring..."
                                              class="w-full bg-gray-50 border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none border"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-8 rounded-b-3xl border-t border-gray-100 flex gap-4">
                            <button type="button" @click="showModal = false" 
                                    class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition-all">
                                Bekor qilish
                            </button>
                            <button type="submit" :disabled="loading" 
                                    class="flex-[2] px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 disabled:opacity-50">
                                <span x-show="!loading">Yuborish</span>
                                <span x-show="loading" class="flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 mr-3 text-white" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Yuklanmoqda...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
