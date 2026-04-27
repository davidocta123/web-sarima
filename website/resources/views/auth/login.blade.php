<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
            
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang</h2>
                <p class="mt-3 text-sm text-gray-500">Silakan masuk untuk mengakses akun Anda</p>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 ml-1 mb-2">Email Address</label>
                        <input id="email" name="email" type="email" required 
                            class="appearance-none block w-full px-4 py-4 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white" 
                            placeholder="nama@email.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 ml-1 mb-2">Password</label>
                        <input id="password" name="password" type="password" required 
                            class="appearance-none block w-full px-4 py-4 border border-gray-200 placeholder-gray-400 text-gray-900 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-md cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">Ingat saya</label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition-colors">Lupa sandi?</a>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        style="background-color: #4f46e5; color: white;" 
                        class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-2xl shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform active:scale-[0.98] uppercase tracking-wider">
                        MASUK SEKARANG
                    </button>
                </div>

                <div class="text-center pt-6 mt-4 border-t border-gray-100">
                    <div class="flex items-center justify-center space-x-4">
                        <a href="/" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>

                        <span class="text-gray-300">|</span>

                        <p class="text-sm text-gray-500">
                            <a href="{{ route('register') }}" class="font-extrabold text-indigo-600 hover:underline transition-all">Belum punya akun? Daftar Gratis</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>