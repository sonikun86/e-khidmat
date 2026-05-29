<x-pengurus-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arsip Surat') }}
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
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Dokumen Arsip</h3>
                        <p class="text-sm text-gray-500">Surat masuk dan surat keluar PAC Anda yang telah selesai diproses dan dipindahkan ke arsip.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal Dibuat/Diterima</th>
                                    <th scope="col" class="px-6 py-3">Pengirim -> Penerima</th>
                                    <th scope="col" class="px-6 py-3">Nomor & Perihal</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surats as $surat)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            {{ $surat->tgl_kirim ? \Carbon\Carbon::parse($surat->tgl_kirim)->format('d M Y H:i') : $surat->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-900">
                                            {{ $surat->pengirim }} &rarr; <span class="text-indigo-600">{{ $surat->penerima }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $surat->nomor_surat }}</div>
                                            <div class="text-sm text-gray-500">{{ $surat->perihal }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ Storage::url($surat->file_surat) }}" target="_blank" class="px-3 py-1 bg-gray-600 text-white text-xs rounded hover:bg-gray-700 inline-block">Lihat Arsip</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada arsip surat.
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
</x-pengurus-layout>
