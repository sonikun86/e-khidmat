<nav class="bg-white border-r border-slate-100 w-64 flex-shrink-0 flex flex-col h-full absolute lg:relative z-30 transition-transform duration-300 transform lg:translate-x-0 shadow-lg lg:shadow-none"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" x-cloak>
    
    <!-- Logo / Brand -->
    <div class="h-16 flex items-center px-6 border-b border-slate-50 bg-white">
        <a href="{{ route('dashboard') }}" class="flex items-center group">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white font-heading font-bold text-lg shadow-md transform group-hover:scale-105 transition-transform duration-300">
                E
            </div>
            <span class="ml-3 font-heading font-bold text-xl tracking-tight text-slate-800 group-hover:text-brand-600 transition-colors">E-Khidmat</span>
        </a>
    </div>

    <!-- Scrollable Navigation Links -->
    <div class="flex-1 overflow-y-auto py-4 px-3 no-scrollbar space-y-1">
        
        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition-colors group">
            <span class="mr-3 text-lg opacity-75 group-hover:opacity-100">📊</span>
            Dashboard
        </a>

        <!-- Section: Manajemen Data -->
        <div class="pt-4 pb-1">
            <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Manajemen Wilayah</p>
        </div>
        
        <a href="{{ route('pengurus.ranting.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('pengurus.ranting.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition-colors group">
            <span class="mr-3 text-lg opacity-75 group-hover:opacity-100">🏘️</span>
            Data Desa / Ranting
        </a>

        <!-- Section: Kesekretariatan -->
        <div class="pt-4 pb-1">
            <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Kesekretariatan</p>
        </div>

        <a href="{{ route('pengurus.surat.masuk') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('pengurus.surat.masuk') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition-colors group">
            <span class="mr-3 text-lg opacity-75 group-hover:opacity-100">📥</span>
            Surat Masuk
            @php $unreadSurat = \App\Models\Surat::whereIn('penerima', [Auth::user()->pac, 'Semua PAC'])->where('status', 'terkirim')->count(); @endphp
            @if($unreadSurat > 0)
                <span class="ml-auto bg-blue-100 text-blue-600 py-0.5 px-2 rounded-full text-xs font-bold">{{ $unreadSurat }}</span>
            @endif
        </a>

        <a href="{{ route('pengurus.surat.keluar') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('pengurus.surat.keluar') || request()->routeIs('pengurus.surat.create') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition-colors group">
            <span class="mr-3 text-lg opacity-75 group-hover:opacity-100">📤</span>
            Surat Keluar
        </a>

        <a href="{{ route('pengurus.surat.arsip') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('pengurus.surat.arsip') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition-colors group">
            <span class="mr-3 text-lg opacity-75 group-hover:opacity-100">🗄️</span>
            Arsip Surat
        </a>

        <a href="{{ route('pengurus.dokumen.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('pengurus.dokumen.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition-colors group">
            <span class="mr-3 text-lg opacity-75 group-hover:opacity-100">📁</span>
            Unduh Dokumen
        </a>
    </div>

    <!-- User Section Bottom -->
    <div class="p-4 border-t border-slate-100 bg-slate-50">
        <a href="{{ route('profile.edit') }}" class="flex items-center w-full group">
            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-bold group-hover:bg-brand-100 group-hover:text-brand-600 transition-colors">
                ⚙️
            </div>
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-700 truncate group-hover:text-brand-600 transition-colors">Pengaturan</p>
                <p class="text-xs text-slate-500 truncate">Profil & Keamanan</p>
            </div>
        </a>
    </div>
</nav>
