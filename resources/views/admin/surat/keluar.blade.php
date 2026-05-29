<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Surat Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold">Surat Keluar & Draft</h3>
                            <p class="text-sm text-gray-500">Surat yang Anda buat untuk dikirimkan ke PAC.</p>
                        </div>
                        <a href="{{ route('admin.surat.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            + Buat Surat Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                                    <th scope="col" class="px-6 py-3">Tujuan</th>
                                    <th scope="col" class="px-6 py-3">Nomor & Perihal</th>
                                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surats as $surat)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            {{ $surat->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-900">
                                            {{ $surat->penerima }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $surat->nomor_surat }}</div>
                                            <div class="text-sm text-gray-500">{{ $surat->perihal }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($surat->status == 'draft')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-300">Draft</span>
                                            @elseif($surat->status == 'terkirim')
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-300">Terkirim</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center space-y-1">
                                            <a href="{{ Storage::url($surat->file_surat) }}" target="_blank" class="block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">Lihat File</a>
                                            
                                            @if($surat->status == 'draft')
                                                <a href="{{ route('admin.surat.edit', $surat->id) }}" class="block w-full px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600 text-center">Edit Draft</a>
                                                <form action="{{ route('admin.surat.kirim', $surat->id) }}" method="POST" onsubmit="return confirm('Kirim surat ini sekarang? Setelah dikirim, tidak bisa dibatalkan.');">
                                                    @csrf
                                                    <button type="submit" class="w-full px-3 py-1 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">Kirim Surat</button>
                                                </form>
                                                <form action="{{ route('admin.surat.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus draft ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">Hapus</button>
                                                </form>
                                            @elseif($surat->status == 'terkirim')
                                                <form action="{{ route('admin.surat.arsipkan', $surat->id) }}" method="POST" onsubmit="return confirm('Pindahkan surat ini ke Arsip?');">
                                                    @csrf
                                                    <button type="submit" class="w-full px-3 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600">Arsipkan</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada surat keluar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
