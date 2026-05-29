<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Draft Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="nomor_surat" :value="__('Nomor Surat')" />
                                <x-text-input id="nomor_surat" name="nomor_surat" type="text" class="mt-1 block w-full" required placeholder="Contoh: 001/PCNU/V/2026" value="{{ old('nomor_surat', $surat->nomor_surat) }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('nomor_surat')" />
                            </div>

                            <div>
                                <x-input-label for="perihal" :value="__('Perihal Surat')" />
                                <x-text-input id="perihal" name="perihal" type="text" class="mt-1 block w-full" required placeholder="Contoh: Undangan Rapat Koordinasi" value="{{ old('perihal', $surat->perihal) }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('perihal')" />
                            </div>

                            <div>
                                <x-input-label for="penerima" :value="__('Tujuan Surat (Penerima)')" />
                                <select id="penerima" name="penerima" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="" disabled>-- Pilih Tujuan --</option>
                                    <option value="Semua PAC" class="font-bold text-indigo-600" {{ old('penerima', $surat->penerima) == 'Semua PAC' ? 'selected' : '' }}>Ke Semua PAC</option>
                                    @foreach($pacs as $pac)
                                        <option value="{{ $pac->nama_pac }}" {{ old('penerima', $surat->penerima) == $pac->nama_pac ? 'selected' : '' }}>{{ $pac->nama_pac }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('penerima')" />
                            </div>

                            <div>
                                <x-input-label for="file_surat" :value="__('Lampiran Surat (Abaikan jika tidak ingin mengganti file)')" />
                                <input id="file_surat" name="file_surat" type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" />
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, Word, atau Gambar (Max 10MB). Biarkan kosong jika tidak mengubah file.</p>
                                <p class="text-sm text-indigo-600 mt-1">File saat ini: <a href="{{ Storage::url($surat->file_surat) }}" target="_blank" class="underline">Lihat File</a></p>
                                <x-input-error class="mt-2" :messages="$errors->get('file_surat')" />
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.surat.keluar') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
