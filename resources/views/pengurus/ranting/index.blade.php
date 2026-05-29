<x-pengurus-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Ranting PAC: ') }} {{ $pac->nama_pac }}
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
                        <h3 class="text-lg font-bold">Daftar Ranting</h3>
                        <a href="{{ route('pengurus.ranting.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            + Tambah Ranting
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Ranting</th>
                                    <th scope="col" class="px-6 py-3">Ketua</th>
                                    <th scope="col" class="px-6 py-3">Masa Khidmat</th>
                                    <th scope="col" class="px-6 py-3 text-center">Total Kader</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($rantings as $ranting)
                                    <tr class="bg-white hover:bg-gray-50 transition-colors" x-data="{ 
                                            isEditing: false,
                                            isLoading: false,
                                            formData: {
                                                nama_ranting: '{{ addslashes($ranting->nama_ranting) }}',
                                                nama_ketua: '{{ addslashes($ranting->nama_ketua ?? '') }}',
                                                masa_khidmat: '{{ addslashes($ranting->masa_khidmat ?? '') }}',
                                                makesta: {{ $ranting->makesta }},
                                                lakmud: {{ $ranting->lakmud }},
                                                latin: {{ $ranting->latin }},
                                                lakut: {{ $ranting->lakut }},
                                                laknas: {{ $ranting->laknas }}
                                            },
                                            originalData: null,
                                            
                                            startEdit() {
                                                this.originalData = JSON.parse(JSON.stringify(this.formData));
                                                this.isEditing = true;
                                            },
                                            
                                            cancelEdit() {
                                                this.formData = JSON.parse(JSON.stringify(this.originalData));
                                                this.isEditing = false;
                                            },
                                            
                                            saveEdit() {
                                                this.isLoading = true;
                                                fetch('{{ route('pengurus.ranting.update', $ranting->id) }}', {
                                                    method: 'PUT',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                                        'Accept': 'application/json'
                                                    },
                                                    body: JSON.stringify(this.formData)
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        this.isEditing = false;
                                                    } else {
                                                        alert('Gagal menyimpan data.');
                                                        this.cancelEdit();
                                                    }
                                                })
                                                .catch(error => {
                                                    alert('Terjadi kesalahan jaringan.');
                                                    this.cancelEdit();
                                                })
                                                .finally(() => {
                                                    this.isLoading = false;
                                                });
                                            }
                                        }">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            <span x-show="!isEditing" x-text="formData.nama_ranting"></span>
                                            <div x-show="isEditing" x-cloak>
                                                <input type="text" x-model="formData.nama_ranting" class="w-full rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span x-show="!isEditing" x-text="formData.nama_ketua || '-'"></span>
                                            <div x-show="isEditing" x-cloak>
                                                <input type="text" x-model="formData.nama_ketua" class="w-full rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ketua">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span x-show="!isEditing" x-text="formData.masa_khidmat || '-'"></span>
                                            <div x-show="isEditing" x-cloak>
                                                <input type="text" x-model="formData.masa_khidmat" class="w-full rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masa Khidmat">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $ranting->makesta + $ranting->lakmud + $ranting->latin + $ranting->lakut + $ranting->laknas }}
                                            <div x-show="isEditing" class="text-[10px] text-gray-400 mt-1">Kader tetap</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <!-- Tombol Tampilan -->
                                            <div x-show="!isEditing" class="flex justify-center space-x-2">
                                                <button @click="startEdit()" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition-colors text-xs font-semibold">
                                                    Inline Edit
                                                </button>
                                                <a href="{{ route('pengurus.ranting.edit', $ranting->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition-colors text-xs font-semibold">
                                                    Full Edit
                                                </a>
                                                <form action="{{ route('pengurus.ranting.destroy', $ranting->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ranting ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors text-xs font-semibold">Hapus</button>
                                                </form>
                                            </div>

                                            <!-- Tombol Edit -->
                                            <div x-show="isEditing" x-cloak class="flex justify-center space-x-2">
                                                <button @click="saveEdit()" :disabled="isLoading" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded-md transition-colors font-bold text-xs flex items-center disabled:opacity-50">
                                                    <span x-show="!isLoading">Simpan</span>
                                                    <span x-show="isLoading" class="animate-spin mr-1">⏳</span>
                                                </button>
                                                <button @click="cancelEdit()" :disabled="isLoading" class="text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-md transition-colors text-xs font-semibold">
                                                    Batal
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 bg-gray-50 rounded-b-lg">
                                            Belum ada data ranting untuk PAC ini.
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
