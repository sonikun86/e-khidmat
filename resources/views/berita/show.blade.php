<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->judul }} - E-Khidmat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:500,600,700&display=swap" rel="stylesheet" />

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
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-brand-600 hover:text-brand-800 font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-12 pb-24">
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                @if($post->gambar)
                    <div class="w-full max-h-[500px] overflow-hidden bg-gray-100 flex items-center justify-center">
                        <img src="{{ Storage::url($post->gambar) }}" alt="{{ $post->judul }}" class="w-full object-cover">
                    </div>
                @endif
                
                <div class="p-8 md:p-12">
                    <div class="flex items-center text-sm text-gray-500 mb-6 font-medium uppercase tracking-wider">
                        <span class="bg-brand-50 text-brand-700 px-3 py-1 rounded-full border border-brand-100">{{ \Carbon\Carbon::parse($post->tanggal)->format('d M Y') }}</span>
                        <span class="mx-3">•</span>
                        <span>Ditulis oleh <span class="text-gray-900 font-bold">{{ $post->penulis }}</span></span>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-heading font-bold text-gray-900 mb-8 leading-tight">
                        {{ $post->judul }}
                    </h1>
                    
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose-headings:font-heading prose-a:text-brand-600 hover:prose-a:text-brand-800">
                        {!! nl2br(e($post->isi)) !!}
                    </div>
                </div>
            </div>
        </article>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 border-t border-gray-800 text-gray-400 text-center text-sm">
        <p>&copy; {{ date('Y') }} E-Khidmat Terpadu. All rights reserved.</p>
    </footer>

</body>
</html>
