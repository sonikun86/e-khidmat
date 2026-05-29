<x-pengurus-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Ranting: ') }} {{ $ranting->nama_ranting }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pengurus.ranting.update', $ranting->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informasi Dasar -->
                            <div class="md:col-span-2 space-y-4">
                                <h3 class="text-lg font-medium border-b pb-2">Informasi Ranting</h3>
                                
                                <div>
                                    <x-input-label for="nama_ranting" :value="__('Nama Ranting (Wajib)')" />
                                    <x-text-input id="nama_ranting" name="nama_ranting" type="text" class="mt-1 block w-full" value="{{ old('nama_ranting', $ranting->nama_ranting) }}" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('nama_ranting')" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="nama_ketua" :value="__('Nama Ketua')" />
                                        <x-text-input id="nama_ketua" name="nama_ketua" type="text" class="mt-1 block w-full" value="{{ old('nama_ketua', $ranting->nama_ketua) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="masa_khidmat" :value="__('Masa Khidmat (Contoh: 2024-2026)')" />
                                        <x-text-input id="masa_khidmat" name="masa_khidmat" type="text" class="mt-1 block w-full" value="{{ old('masa_khidmat', $ranting->masa_khidmat) }}" />
                                    </div>
                                </div>
                            </div>

                            <!-- Jumlah Kader -->
                            <div class="md:col-span-2 space-y-4 mt-4">
                                <h3 class="text-lg font-medium border-b pb-2">Data Jumlah Kader</h3>
                                
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                    <div>
                                        <x-input-label for="makesta" :value="__('Makesta')" />
                                        <x-text-input id="makesta" name="makesta" type="number" min="0" class="mt-1 block w-full" value="{{ old('makesta', $ranting->makesta) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="lakmud" :value="__('Lakmud')" />
                                        <x-text-input id="lakmud" name="lakmud" type="number" min="0" class="mt-1 block w-full" value="{{ old('lakmud', $ranting->lakmud) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="latin" :value="__('Latin')" />
                                        <x-text-input id="latin" name="latin" type="number" min="0" class="mt-1 block w-full" value="{{ old('latin', $ranting->latin) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="lakut" :value="__('Lakut')" />
                                        <x-text-input id="lakut" name="lakut" type="number" min="0" class="mt-1 block w-full" value="{{ old('lakut', $ranting->lakut) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="laknas" :value="__('Laknas')" />
                                        <x-text-input id="laknas" name="laknas" type="number" min="0" class="mt-1 block w-full" value="{{ old('laknas', $ranting->laknas) }}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('pengurus.ranting.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-pengurus-layout>
