<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Cabang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if($pendingPengurus > 0)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 shadow-sm" role="alert">
                    <p class="font-bold">Perhatian!</p>
                    <p>Ada {{ $pendingPengurus }} akun Pengurus PAC yang menunggu persetujuan Anda. <a href="{{ route('admin.pengurus.index') }}" class="underline font-bold">Tinjau sekarang</a>.</p>
                </div>
            @endif

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- PAC Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <span class="text-blue-600 text-2xl">🏢</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total PAC</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $totalPac }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.pac.index') }}" class="font-medium text-blue-600 hover:text-blue-500">Lihat Semua PAC</a>
                        </div>
                    </div>
                </div>

                <!-- Ranting Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <span class="text-green-600 text-2xl">🏘️</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Ranting</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $totalRanting }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kader Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                <span class="text-indigo-600 text-2xl">👥</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Kader</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ number_format($totalKader, 0, ',', '.') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Berita Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                <span class="text-purple-600 text-2xl">📰</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Berita</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $totalBerita }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.post.index') }}" class="font-medium text-purple-600 hover:text-purple-500">Kelola Berita</a>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Baris Kedua: Chart dan Surat -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Grafik Kader -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="mr-2 text-xl">📈</span> Distribusi Kader per PAC
                    </h3>
                </div>
                <div class="p-6 flex-1 flex items-center justify-center relative min-h-[300px]">
                    <canvas id="kaderChart"></canvas>
                </div>
            </div>

            <!-- Surat Masuk Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="mr-2 text-xl">📨</span> Surat Masuk Terbaru
                    </h3>
                    <a href="{{ route('admin.surat.masuk') }}" class="text-sm text-brand-600 hover:text-brand-800 font-medium bg-brand-50 hover:bg-brand-100 px-3 py-1 rounded-md transition-colors">Semua &rarr;</a>
                </div>
                
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">Pengirim</th>
                                <th scope="col" class="px-6 py-3 font-semibold">Perihal</th>
                                <th scope="col" class="px-6 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($suratMasukTerbaru as $surat)
                                <tr class="bg-white hover:bg-brand-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $surat->pengirim }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $surat->tgl_kirim ? \Carbon\Carbon::parse($surat->tgl_kirim)->diffForHumans() : '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800 line-clamp-1">{{ $surat->perihal }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $surat->nomor_surat }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ Storage::url($surat->file_surat) }}" target="_blank" class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-xs font-semibold rounded-lg transition-all duration-200">
                                            Buka
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 mb-3">
                                            <span class="text-xl">📭</span>
                                        </div>
                                        <p class="text-gray-500 font-medium">Tidak ada surat masuk baru</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('kaderChart').getContext('2d');
            
            // Create gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(34, 197, 94, 0.8)'); // Brand 500
            gradient.addColorStop(1, 'rgba(34, 197, 94, 0.2)');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Total Kader',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: gradient,
                        borderColor: '#16a34a',
                        borderWidth: 1,
                        borderRadius: 4,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { family: 'Outfit, sans-serif', size: 14 },
                            bodyFont: { family: 'Inter, sans-serif', size: 13 },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            },
                            ticks: {
                                font: { family: 'Inter, sans-serif' },
                                color: '#64748b'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: { family: 'Inter, sans-serif' },
                                color: '#64748b',
                                maxRotation: 45,
                                minRotation: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
