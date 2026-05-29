<x-pengurus-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengurus PAC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-sm" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Welcome Alert -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-1">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>
                        <p class="text-gray-600">Anda mengelola data wilayah: <span class="font-bold text-indigo-600 px-2 py-1 bg-indigo-50 rounded-md">{{ $pac ? $pac->nama_pac : 'Data PAC Tidak Ditemukan' }}</span></p>
                    </div>
                    <div class="hidden md:block">
                        <span class="text-4xl">👋</span>
                    </div>
                </div>
            </div>

            @if($pac)
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Ranting Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 flex flex-col justify-between">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <span class="text-blue-600 text-2xl">🏘️</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Desa / Ranting</dt>
                                    <dd class="text-3xl font-bold text-gray-900">{{ $stats['total_ranting'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                        <div class="text-sm text-right">
                            <a href="{{ route('pengurus.ranting.index') }}" class="font-medium text-blue-600 hover:text-blue-500">Kelola Data Ranting &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Total Kader Card (Makesta & Lakmud) -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 flex flex-col justify-between">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <span class="text-green-600 text-2xl">🌱</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Kader Dasar</dt>
                                </dl>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['makesta'] }}</div>
                                <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Makesta</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['lakmud'] }}</div>
                                <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Lakmud</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Kader Card (Lanjutan) -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 flex flex-col justify-between">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                <span class="text-purple-600 text-2xl">🎓</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Kader Lanjutan</dt>
                                </dl>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div>
                                <div class="text-xl font-bold text-gray-900">{{ $stats['latin'] }}</div>
                                <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Latin</div>
                            </div>
                            <div>
                                <div class="text-xl font-bold text-gray-900">{{ $stats['lakut'] }}</div>
                                <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Lakut</div>
                            </div>
                            <div>
                                <div class="text-xl font-bold text-gray-900">{{ $stats['laknas'] }}</div>
                                <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Laknas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mt-6">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="mr-2 text-xl">📊</span> Distribusi Kader PAC {{ $pac->nama_pac }}
                    </h3>
                </div>
                <div class="p-6 flex items-center justify-center relative min-h-[300px]">
                    <canvas id="kaderPieChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Surat Masuk Terbaru -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <span class="mr-2 text-xl">📩</span> Surat Masuk Cabang
                        </h3>
                        <a href="{{ route('pengurus.surat.masuk') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Lihat Semua &rarr;</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Waktu</th>
                                    <th scope="col" class="px-6 py-3">Perihal & Nomor</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suratMasukTerbaru as $surat)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            {{ $surat->tgl_kirim ? \Carbon\Carbon::parse($surat->tgl_kirim)->diffForHumans() : '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $surat->perihal }}</div>
                                            <div class="text-xs text-gray-500 mt-1">{{ $surat->nomor_surat }}</div>
                                            @if($surat->penerima == 'Semua PAC')
                                                <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-purple-100 text-purple-800">
                                                    Broadcast
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ Storage::url($surat->file_surat) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-md text-xs font-semibold transition-colors">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <span class="text-3xl mb-2">📬</span>
                                                <p>Belum ada surat masuk dari Cabang.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dokumen Cabang -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <span class="mr-2 text-xl">📁</span> Dokumen Template
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($dokumenTerbaru as $dokumen)
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 mt-1">
                                    <span class="text-gray-400 text-xl">📄</span>
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $dokumen->nama_dokumen }}</p>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $dokumen->keterangan }}</p>
                                </div>
                                <div class="ml-2 flex-shrink-0">
                                    <a href="{{ Storage::url($dokumen->file_path) }}" download class="text-indigo-600 hover:text-indigo-900 p-1 block">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-500">
                                <span class="text-2xl mb-2 block">📭</span>
                                <p class="text-sm">Tidak ada dokumen dari Cabang.</p>
                            </div>
                        @endforelse

                        @if(count($dokumenTerbaru) > 0)
                            <a href="{{ route('pengurus.dokumen.index') }}" class="mt-4 block w-full text-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Lihat Seluruh Dokumen &rarr;
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('kaderPieChart');
            if (ctx) {
                new Chart(ctx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Makesta', 'Lakmud', 'Latin', 'Lakut', 'Laknas'],
                        datasets: [{
                            data: [
                                {{ $stats['makesta'] }},
                                {{ $stats['lakmud'] }},
                                {{ $stats['latin'] }},
                                {{ $stats['lakut'] }},
                                {{ $stats['laknas'] }}
                            ],
                            backgroundColor: [
                                '#22c55e', // Green for Makesta
                                '#3b82f6', // Blue for Lakmud
                                '#a855f7', // Purple for Latin
                                '#f59e0b', // Yellow for Lakut
                                '#ef4444'  // Red for Laknas
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    font: { family: 'Inter, sans-serif' },
                                    color: '#475569',
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleFont: { family: 'Outfit, sans-serif', size: 14 },
                                bodyFont: { family: 'Inter, sans-serif', size: 13 },
                                padding: 12,
                                cornerRadius: 8
                            }
                        },
                        cutout: '65%'
                    }
                });
            }
        });
    </script>
</x-pengurus-layout>
