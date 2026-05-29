<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 font-heading">Pendaftaran Pengurus PAC</h2>
        <p class="text-sm text-gray-500 mt-2">Daftarkan akun untuk PAC Anda agar dapat terhubung dengan sistem Cabang.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap Ketua / Pengurus</label>
            <input id="nama_lengkap" type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required autofocus
                class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Masukkan nama lengkap">
            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Tempat Lahir -->
            <div>
                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                    class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Contoh: Lamongan">
                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2 text-red-500 text-xs" />
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                    class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors text-gray-600">
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2 text-red-500 text-xs" />
            </div>
        </div>

        <!-- NIA (Opsional) -->
        <div>
            <label for="nia" class="block text-sm font-medium text-gray-700">Nomor Induk Anggota (NIA) <span class="text-gray-400 font-normal">- Opsional</span></label>
            <input id="nia" type="text" name="nia" value="{{ old('nia') }}"
                class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Contoh: 11.22.33.4444">
            <x-input-error :messages="$errors->get('nia')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Pilih PAC / PK -->
        <div>
            <label for="pac" class="block text-sm font-medium text-gray-700">Asal PAC / PK</label>
            <select id="pac" name="pac" required
                class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors text-gray-700">
                <option value="" disabled selected>-- Pilih PAC / PK Anda --</option>
                @foreach($pacs as $p)
                    <option value="{{ $p->nama_pac }}" {{ old('pac') == $p->nama_pac ? 'selected' : '' }}>{{ $p->nama_pac }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('pac')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Username -->
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Username <span class="text-gray-400 font-normal">- Untuk login</span></label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username"
                class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Contoh: paktua_pac">
            <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Minimal 8 karakter">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Ketik ulang password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all transform hover:-translate-y-0.5">
                Daftar Akun
            </button>
        </div>
        
        <div class="text-center mt-6 text-sm text-gray-600 pb-2">
            Sudah mendaftar sebelumnya? 
            <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-500">Masuk di sini</a>
        </div>
    </form>
</x-guest-layout>
