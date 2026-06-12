<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'E-Khidmat') }} - Portal Organisasi</title>
    <meta property="og:site_name" content="E-KHIDMAT">
    <script type="application/ld+json">
    {
      "@context" : "https://schema.org",
      "@type" : "WebSite",
      "name" : "E-KHIDMAT",
      "url" : "https://pcipnubabat.web.id/"
    }
    </script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind -->
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }
        .hero-pattern {
            background-color: #f0fdf4;
            background-image: radial-gradient(#22c55e 0.5px, transparent 0.5px), radial-gradient(#22c55e 0.5px, #f0fdf4 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.8;
        }
        .gradient-text {
            background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800 selection:bg-brand-500 selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white font-heading font-bold text-xl shadow-lg">
                        E
                    </div>
                    <span class="font-heading font-bold text-2xl text-gray-900 tracking-tight">E-Khidmat</span>
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="flex space-x-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="font-medium text-brand-700 hover:text-brand-900 px-4 py-2 rounded-lg hover:bg-brand-50 transition-colors">Masuk Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-medium bg-gray-900 text-white px-6 py-2.5 rounded-full hover:bg-brand-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Login Sistem</a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/bg-utama.jpg') }}" class="w-full h-full object-cover object-center filter brightness-[0.70]" alt="Hero Background">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-gray-900/70 via-gray-900/20 to-gray-50 z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-fade-in">
            <span class="inline-block py-1 px-3 rounded-full bg-brand-500/20 text-brand-100 font-semibold text-sm mb-6 border border-brand-500/30 backdrop-blur-sm">
                🚀 Transformasi Digital Organisasi
            </span>
            <h1 class="font-heading text-5xl md:text-7xl font-extrabold tracking-tight mb-8 leading-tight text-white drop-shadow-md">
                Modernisasi Administrasi <br/> <span class="text-brand-300">E-Khidmat Terpadu</span>
            </h1>
            <p class="mt-4 text-xl text-gray-200 max-w-2xl mx-auto font-medium mb-10 drop-shadow">
                Platform sistem informasi manajemen administrasi terpusat untuk mempermudah koordinasi Cabang dan PAC secara digital, cepat, dan transparan.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#berita" class="bg-brand-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-700 transition-all shadow-lg hover:shadow-brand-500/30 transform hover:-translate-y-1">
                    Jelajahi Berita
                </a>
                <a href="{{ route('login') }}" class="bg-white text-gray-900 border border-gray-200 px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-50 transition-all shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    Login Pengurus
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 opacity-0 animate-[slideUp_0.8s_ease-out_ forwards]" style="animation-delay: 0.2s;">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan Sistem</h2>
                <div class="w-20 h-1 bg-brand-500 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="glass-card p-8 rounded-3xl hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-600 mb-6 text-2xl shadow-inner">
                        📊
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Database Terintegrasi</h3>
                    <p class="text-gray-600 leading-relaxed">Penyimpanan data Ranting dan jumlah kader yang terpusat dan dapat diakses secara real-time oleh pengurus tingkat Cabang maupun PAC.</p>
                </div>
                
                <div class="glass-card p-8 rounded-3xl hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-600 mb-6 text-2xl shadow-inner">
                        📨
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">E-Surat Menyurat</h3>
                    <p class="text-gray-600 leading-relaxed">Fasilitas pengiriman surat keluar dan masuk antar instansi (Cabang-PAC) secara elektronik dengan status pelacakan yang jelas.</p>
                </div>

                <div class="glass-card p-8 rounded-3xl hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-600 mb-6 text-2xl shadow-inner">
                        📁
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Arsip Digital</h3>
                    <p class="text-gray-600 leading-relaxed">Pengelolaan template dokumen sekretariat dan penyimpanan arsip surat masa lampau yang tersusun rapi dan mudah dicari kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News/Portal Section -->
    <section id="berita" class="py-24 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="font-heading text-4xl font-bold text-gray-900 mb-2">Portal Informasi</h2>
                    <p class="text-gray-600">Berita dan pembaruan terbaru dari organisasi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <a href="{{ route('berita.show', $post->id) }}" class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col group border border-gray-100">
                        @if($post->gambar)
                            <div class="h-56 overflow-hidden relative">
                                <img src="{{ Storage::url($post->gambar) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        @else
                            <div class="h-56 bg-brand-50 flex items-center justify-center border-b border-gray-100 group-hover:bg-brand-100 transition-colors">
                                <span class="text-5xl opacity-20">📰</span>
                            </div>
                        @endif
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center text-xs text-gray-500 mb-3 font-medium uppercase tracking-wider">
                                <span>{{ \Carbon\Carbon::parse($post->tanggal)->format('d M Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>Oleh {{ $post->penulis }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight group-hover:text-brand-600 transition-colors">
                                {{ $post->judul }}
                            </h3>
                            <p class="text-gray-600 mb-6 line-clamp-3 text-sm">
                                {{ Str::limit(strip_tags($post->isi), 120) }}
                            </p>
                            <div class="mt-auto">
                                <span class="inline-flex items-center font-medium text-brand-600 text-sm group-hover:text-brand-800">
                                    Baca selengkapnya 
                                    <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center glass-card rounded-3xl">
                        <span class="text-4xl mb-4 block">📭</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada informasi terbaru</h3>
                        <p class="text-gray-500">Berita dan pembaruan organisasi akan tampil di sini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 pt-16 pb-8 border-t border-gray-800 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <!-- Branding -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center text-white font-heading font-bold text-sm shadow-lg shadow-brand-500/20">E</div>
                        <span class="font-heading font-bold text-2xl text-white tracking-tight">E-Khidmat</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-6">
                        Platform sistem informasi manajemen administrasi terpusat untuk mempermudah koordinasi Cabang dan PAC secara digital, cepat, dan transparan.
                    </p>
                </div>
                
                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-bold mb-6 font-heading tracking-wide uppercase text-sm">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start">
                            <span class="mr-3 text-brand-500">📍</span>
                            <span>Gedung Sekretariat Cabang,<br/>Jl. Raya Babat - Surabaya No. 9 Ds. Tritunggal Kec. Babat, Kab. Lamongan</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3 text-brand-500">📞</span>
                            <span>0857 4864 9420/0821 4129 5922</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3 text-brand-500">✉️</span>
                            <span>pcipnubabat1954@gmail.com</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Sosial Media -->
                <div>
                    <h4 class="text-white font-bold mb-6 font-heading tracking-wide uppercase text-sm">Sosial Media</h4>
                    <p class="text-sm mb-4">Ikuti akun resmi kami untuk mendapatkan informasi dan pembaruan terbaru.</p>
                    <div class="flex space-x-4">
                        <!-- Facebook -->
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-500 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/pcipnubabat/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-500 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                        </a>
                        <!-- Twitter/X -->
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-500 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                        </a>
                        <!-- YouTube -->
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-500 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M21.582 7.042c-.225-.845-.889-1.509-1.734-1.734C18.32 4.9 12 4.9 12 4.9s-6.32 0-7.848.408c-.845.225-1.509.889-1.734 1.734C2 8.57 2 12 2 12s0 3.43.418 4.958c.225.845.889 1.509 1.734 1.734C5.68 19.1 12 19.1 12 19.1s6.32 0 7.848-.408c.845-.225 1.509-.889 1.734-1.734C22 15.43 22 12 22 12s0-3.43-.418-4.958zM9.545 15.068V8.932L14.818 12l-5.273 3.068z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs">
                <p>&copy; {{ date('Y') }} E-Khidmat Terpadu. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
