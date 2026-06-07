<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 font-heading">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-500 mt-2">Silakan login untuk mengakses dashboard.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Username -->
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input id="username" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" 
                class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm placeholder-gray-400
                focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Masukkan username Anda">
            <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <a href="https://wa.me/628000000000?text=Halo%20Admin,%20saya%20lupa%20password%20akun%20E-Khidmat%20saya.%20Mohon%20bantu%20di-reset." target="_blank" class="text-xs font-semibold text-brand-600 hover:text-brand-500">
                        Lupa password?
                    </a>
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm placeholder-gray-400
                focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded cursor-pointer">
            <label for="remember_me" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                {{ __('Ingat Saya') }}
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all transform hover:-translate-y-0.5">
                Masuk Sistem
            </button>
        </div>
        
        <div class="text-center mt-6 text-sm text-gray-600">
            Belum punya akun PAC? 
            <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-500">Daftar sekarang</a>
        </div>
    </form>
</x-guest-layout>
