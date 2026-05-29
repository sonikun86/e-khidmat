<x-pengurus-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dokumen Sekretariat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Template & Dokumen</h3>
                        <p class="text-sm text-gray-500">Anda dapat mengunduh format surat atau dokumen lainnya yang disediakan oleh Admin Cabang di sini.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama Dokumen</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Upload</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $index => $dokumen)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $dokumen->nama_dokumen }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $dokumen->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank" class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Download</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada dokumen yang tersedia.
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
