<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Portal Berita') }}
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
                            <h3 class="text-lg font-bold">Daftar Berita</h3>
                            <p class="text-sm text-gray-500">Berita yang diterbitkan akan tampil di halaman depan aplikasi.</p>
                        </div>
                        <a href="{{ route('admin.post.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            + Tulis Berita
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Judul Berita</th>
                                    <th scope="col" class="px-6 py-3">Penulis</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($post->tanggal)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-900">
                                            {{ $post->judul }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $post->penulis }}
                                        </td>
                                        <td class="px-6 py-4 text-center space-x-2">
                                            <a href="{{ route('admin.post.edit', $post->id) }}" class="px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600">Edit</a>
                                            <form action="{{ route('admin.post.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus berita ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada berita yang diterbitkan.
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
