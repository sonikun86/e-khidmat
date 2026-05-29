<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Khidmat') }} - Pengurus PAC</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            heading: ['Outfit', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                50: '#f0fdf4',
                                100: '#dcfce7',
                                500: '#22c55e',
                                600: '#16a34a',
                                700: '#15803d',
                                900: '#14532d',
                            }
                        }
                    }
                }
            }
        </script>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            .hero-pattern {
                background-color: #f8fafc;
                background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
                background-size: 20px 20px;
            }
            .glass-panel {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
            .sidebar-link-active {
                background: linear-gradient(90deg, #dcfce7 0%, transparent 100%);
                border-left: 4px solid #16a34a;
                color: #15803d;
                font-weight: 600;
            }
            .sidebar-link {
                border-left: 4px solid transparent;
                color: #475569;
                transition: all 0.2s ease;
            }
            .sidebar-link:hover {
                background: linear-gradient(90deg, #f1f5f9 0%, transparent 100%);
                border-left: 4px solid #94a3b8;
                color: #0f172a;
            }
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-800 hero-pattern min-h-screen flex" x-data="{ sidebarOpen: false }">
        
        <!-- Overlay for Mobile -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <!-- Sidebar -->
        @include('layouts.pengurus-navigation')

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
            
            <!-- Topbar (Glassmorphism) -->
            <header class="h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 glass-panel z-10 shadow-sm sticky top-0">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-md text-slate-500 hover:text-brand-600 hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <!-- Page Header (Optional) -->
                <div class="hidden sm:block flex-1 ml-4 lg:ml-0 text-lg font-bold font-heading text-slate-800">
                    {{ $header ?? 'Area Pengurus PAC' }}
                </div>

                <!-- Right Topbar: Notifications & Profile -->
                <div class="flex items-center space-x-4 ml-auto">
                    
                    @php
                        // Notifikasi Pengurus: Surat masuk ke PAC-nya atau 'Semua PAC'
                        $unreadSuratCount = \App\Models\Surat::whereIn('penerima', [Auth::user()->pac, 'Semua PAC'])
                                            ->where('status', 'terkirim')
                                            ->count();
                    @endphp

                    <!-- Notification Bell -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="p-2 text-slate-500 hover:text-brand-600 transition-colors relative rounded-full hover:bg-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            
                            @if($unreadSuratCount > 0)
                            <!-- Badge Merah Animasi -->
                            <span class="absolute top-1 right-1 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                            </span>
                            @endif
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="notifOpen" x-transition x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50">
                            <div class="p-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                                <h4 class="font-bold text-slate-800 text-sm">Pusat Notifikasi</h4>
                                <span class="text-xs bg-brand-100 text-brand-700 font-bold px-2 py-0.5 rounded-full">{{ $unreadSuratCount }} Baru</span>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                @if($unreadSuratCount > 0)
                                <a href="{{ route('pengurus.surat.masuk') }}" class="block p-4 border-b border-slate-50 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-blue-100 text-blue-600 rounded-full p-2 mr-3">📩</div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">Surat Masuk Baru</p>
                                            <p class="text-xs text-slate-500 mt-1">Anda memiliki {{ $unreadSuratCount }} surat masuk dari Cabang.</p>
                                        </div>
                                    </div>
                                </a>
                                @else
                                <div class="p-6 text-center text-slate-500 text-sm">
                                    <div class="text-4xl mb-2">🎉</div>
                                    Tidak ada surat masuk baru.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-2 p-1 pl-2 pr-3 rounded-full border border-slate-200 bg-white hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-white flex items-center justify-center font-bold text-sm shadow-inner">
                                {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-700 hidden sm:block">{{ explode(' ', Auth::user()->nama_lengkap)[0] }}</span>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Profile Menu -->
                        <div x-show="profileOpen" x-transition x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-slate-50 mb-1">
                                <p class="text-xs text-slate-500">Login sebagai</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->nama_lengkap }}</p>
                                <p class="text-[10px] text-brand-600 font-bold uppercase mt-1">{{ Auth::user()->pac }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700 transition-colors">Pengaturan Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Wrapper for glass effect on content if needed -->
                {{ $slot }}
            </main>
            
        </div>
    </body>
</html>
