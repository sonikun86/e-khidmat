<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pengurus PAC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PAC</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr x-data="{ 
                                    isEditing: false, 
                                    formData: {
                                        nama_lengkap: '{{ addslashes($user->nama_lengkap) }}',
                                        pac: '{{ addslashes($user->pac) }}',
                                        status: '{{ $user->status }}'
                                    },
                                    originalData: null,
                                    isLoading: false,
                                    
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
                                        fetch('{{ route('admin.pengurus.update', $user->id) }}', {
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
                                                // Optional: show a toast notification here
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
                                }"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div x-show="!isEditing">
                                        <span x-text="formData.nama_lengkap"></span> <br>
                                        <small class="text-gray-500">{{ $user->username }}</small>
                                    </div>
                                    <div x-show="isEditing" x-cloak>
                                        <input type="text" x-model="formData.nama_lengkap" class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-brand-500 focus:border-brand-500">
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div x-show="!isEditing">
                                        <span x-text="formData.pac"></span>
                                    </div>
                                    <div x-show="isEditing" x-cloak>
                                        <input type="text" x-model="formData.pac" class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-brand-500 focus:border-brand-500">
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div x-show="!isEditing">
                                        <span x-show="formData.status == 'aktif' || formData.status == '1'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        <span x-show="formData.status == 'pending' || formData.status == '0'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    </div>
                                    <div x-show="isEditing" x-cloak>
                                        <select x-model="formData.status" class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-brand-500 focus:border-brand-500">
                                            <option value="1">Aktif</option>
                                            <option value="0">Pending</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <!-- View Mode Actions -->
                                    <div x-show="!isEditing" class="flex items-center space-x-2">
                                        <button @click="startEdit()" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-2 py-1 rounded transition-colors text-xs border border-indigo-200">
                                            Edit
                                        </button>
                                        
                                        @if($user->status == 0)
                                        <form action="{{ route('admin.pengurus.approve', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 px-2 py-1 rounded text-xs border border-green-200 transition-colors">
                                                Setujui
                                            </button>
                                        </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.pengurus.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-2 py-1 rounded text-xs border border-red-200 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Edit Mode Actions -->
                                    <div x-show="isEditing" x-cloak class="flex items-center space-x-2">
                                        <button @click="saveEdit()" :disabled="isLoading" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded transition-colors text-xs flex items-center shadow-sm disabled:opacity-50">
                                            <span x-show="!isLoading">Simpan</span>
                                            <span x-show="isLoading" class="animate-spin mr-1">⏳</span>
                                        </button>
                                        
                                        <button @click="cancelEdit()" :disabled="isLoading" class="text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 px-3 py-1 rounded transition-colors text-xs shadow-sm">
                                            Batal
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 bg-gray-50 rounded-b-lg">Belum ada pengurus terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
