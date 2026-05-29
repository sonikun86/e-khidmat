<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data PAC & PK') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ editingId: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm" role="alert">
                    <p class="font-bold">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Form Tambah PAC/PK -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="mr-2">➕</span> Tambah PAC / PK Baru
                    </h3>
                    
                    <form action="{{ route('admin.pac.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama PAC / PK</label>
                                <input type="text" name="nama_pac" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: PAC Babat" required>
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ketua (Opsional)</label>
                                <input type="text" name="ketua_pac" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Nama Ketua">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Masa Khidmat (Opsional)</label>
                                <input type="text" name="masa_khidmat" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: 2024-2026">
                            </div>
                            <div class="md:col-span-1 flex items-end">
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition-colors text-sm h-[38px]">
                                    Simpan Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar PAC/PK -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <span class="mr-2">📋</span> Daftar Pimpinan Anak Cabang & Komisariat
                    </h3>
                    <a href="{{ route('admin.pac.export') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-md shadow-sm transition-colors text-sm flex items-center">
                        <span class="mr-2">📥</span> Export CSV
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama PAC / PK</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ketua</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Masa Khidmat</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pacs as $index => $pac)
                            <tr class="hover:bg-gray-50 transition-colors" x-data="{ 
                                    isEditing: false,
                                    isLoading: false,
                                    formData: {
                                        nama_pac: '{{ addslashes($pac->nama_pac) }}',
                                        ketua_pac: '{{ addslashes($pac->ketua_pac ?? '') }}',
                                        masa_khidmat: '{{ addslashes($pac->masa_khidmat ?? '') }}'
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
                                        fetch('{{ route('admin.pac.update', $pac->id) }}', {
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                
                                <!-- Mode Tampilan / Edit -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <span x-show="!isEditing" x-text="formData.nama_pac"></span>
                                    <div x-show="isEditing" x-cloak>
                                        <input type="text" x-model="formData.nama_pac" class="w-full rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span x-show="!isEditing" x-text="formData.ketua_pac || '-'"></span>
                                    <div x-show="isEditing" x-cloak>
                                        <input type="text" x-model="formData.ketua_pac" class="w-full rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ketua">
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div x-show="!isEditing">
                                        <span x-show="formData.masa_khidmat" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800" x-text="formData.masa_khidmat"></span>
                                        <span x-show="!formData.masa_khidmat">-</span>
                                    </div>
                                    <div x-show="isEditing" x-cloak>
                                        <input type="text" x-model="formData.masa_khidmat" class="w-full rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masa Khidmat">
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <!-- Tombol Tampilan -->
                                    <div x-show="!isEditing" class="flex justify-center space-x-2">
                                        <button @click="startEdit()" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition-colors">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.pac.destroy', $pac->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- Tombol Edit -->
                                    <div x-show="isEditing" x-cloak class="flex justify-center space-x-2">
                                        <button @click="saveEdit()" :disabled="isLoading" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded-md transition-colors font-bold flex items-center disabled:opacity-50">
                                            <span x-show="!isLoading">Simpan</span>
                                            <span x-show="isLoading" class="animate-spin mr-1">⏳</span>
                                        </button>
                                        <button @click="cancelEdit()" :disabled="isLoading" class="text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-md transition-colors">
                                            Batal
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <span class="text-3xl mb-2">🏢</span>
                                        <p>Belum ada data PAC/PK. Silakan tambahkan melalui form di atas.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
