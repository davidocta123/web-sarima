<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
            
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Atur Ulang Sandi</h2>
                <p class="mt-4 text-sm text-gray-500 leading-relaxed">
                    {{ __('Lupa kata sandi? Tidak masalah. Beritahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang melalui email.') }}
                </p>
            </div>

            <x-auth-session-status class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl text-sm border border-green-100" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-6">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold ml-1 mb-2" />
                    <x-text-input id="email" 
                        class="appearance-none block w-full px-4 py-4 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50" 
                        type="email" name="email" :value="old('email')" required autofocus 
                        placeholder="Masukkan email terdaftar" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        style="background-color: #4f46e5; color: white;" 
                        class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-2xl shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform active:scale-[0.98] uppercase tracking-wider">
                        {{ __('Kirim Link Reset') }}
                    </button>
                </div>

                <div class="text-center pt-6 mt-4 border-t border-gray-100">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Halaman Masuk
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>