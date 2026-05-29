<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Khidmat') }} - Autentikasi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (CDN untuk konsistensi UI Premium) -->
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
    <style>
        .hero-pattern {
            background-color: #f0fdf4;
            background-image: radial-gradient(#22c55e 0.5px, transparent 0.5px), radial-gradient(#22c55e 0.5px, #f0fdf4 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.8;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
        }
        .gradient-text {
            background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased selection:bg-brand-500 selection:text-white relative min-h-screen">
    <!-- Background -->
    <div class="fixed inset-0 hero-pattern z-0"></div>
    <div class="fixed inset-0 bg-gradient-to-br from-transparent via-white/50 to-white/90 z-0"></div>

    <div class="relative z-10 flex flex-col sm:justify-center items-center min-h-screen pt-6 sm:pt-0 pb-12">
        <div class="mb-6 flex flex-col items-center">
            <a href="/" class="flex flex-col items-center group">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white font-heading font-bold text-3xl shadow-lg transform group-hover:scale-105 transition-transform duration-300">
                    E
                </div>
                <span class="mt-4 font-heading font-bold text-2xl tracking-tight gradient-text">E-Khidmat</span>
            </a>
            <p class="text-sm text-gray-500 mt-1 font-medium">Sistem Informasi Manajemen Administrasi</p>
        </div>

        <div class="w-full sm:max-w-xl px-8 py-10 bg-white shadow-xl sm:rounded-3xl glass-card relative overflow-hidden">
            <!-- Dekorasi pojok -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-50 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-green-50 rounded-full blur-3xl opacity-60"></div>
            
            <div class="relative z-10">
                {{ $slot }}
            </div>
        </div>
        
        <div class="mt-8 text-sm text-gray-500 font-medium">
            &copy; {{ date('Y') }} E-Khidmat Terpadu. All rights reserved.
        </div>
    </div>
</body>
</html>
