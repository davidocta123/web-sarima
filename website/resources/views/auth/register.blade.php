<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
            
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Buat Akun Baru</h2>
                <p class="mt-3 text-sm text-gray-500">Daftar sekarang untuk mulai menggunakan layanan kami</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-medium ml-1" />
                    <div class="mt-1.5">
                        <x-text-input id="name" 
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 rounded-xl transition duration-200 outline-none" 
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium ml-1" />
                    <div class="mt-1.5">
                        <x-text-input id="email" 
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 rounded-xl transition duration-200 outline-none" 
                            type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium ml-1" />
                    <div class="mt-1.5">
                        <x-text-input id="password" 
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 rounded-xl transition duration-200 outline-none"
                            type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 font-medium ml-1" />
                    <div class="mt-1.5">
                        <x-text-input id="password_confirmation" 
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 rounded-xl transition duration-200 outline-none"
                            type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="pt-4 space-y-4">
                    <button type="submit" 
                        style="background-color: #4f46e5; color: white;" 
                        class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold uppercase tracking-widest hover:bg-indigo-700 transition-all duration-200 transform active:scale-[0.95]">
                        DAFTAR SEKARANG
                    </button>

                    <div class="text-center">
                        <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition-colors" href="{{ route('login') }}">
                            {{ __('Sudah punya akun? Masuk di sini') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>