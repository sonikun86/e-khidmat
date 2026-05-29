<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tulis Berita Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="judul" :value="__('Judul Berita')" />
                                <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                            </div>

                            <div>
                                <x-input-label for="gambar" :value="__('Gambar Thumbnail (Opsional)')" />
                                <input id="gambar" name="gambar" type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept="image/*" />
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max 5MB)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('gambar')" />
                            </div>

                            <div>
                                <x-input-label for="isi" :value="__('Isi Berita')" />
                                <textarea id="isi" name="isi" rows="10" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('isi')" />
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.post.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Terbitkan Berita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
