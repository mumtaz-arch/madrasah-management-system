<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Prestasi</h1>
            <p class="text-gray-500">Kelola prestasi untuk landing page</p>
        </div>
        <button wire:click="openModal" class="btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Prestasi
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tahun</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tingkat</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($achievements as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->urutan }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->judul }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->tahun ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->tingkat ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button wire:click="edit({{ $item->id }})" class="btn-action-edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button wire:click="confirmDelete({{ $item->id }})" class="btn-action-delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada prestasi</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($achievements->hasPages())<div class="px-6 py-4 border-t">{{ $achievements->links('vendor.pagination.tailwind') }}</div>@endif
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                    <form wire:submit="save">
                        <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold">{{ $editingId ? 'Edit' : 'Tambah' }} Prestasi</h3></div>
                        <div class="p-6 space-y-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Judul</label><input type="text" wire:model="judul" class="w-full px-4 py-2 border border-gray-300 rounded-lg">@error('judul')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror</div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label><textarea wire:model="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea></div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label><input type="text" wire:model="tahun" maxlength="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label><select wire:model="tingkat" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><option value="">Pilih</option><option value="Nasional">Nasional</option><option value="Provinsi">Provinsi</option><option value="Kabupaten">Kabupaten</option><option value="Kecamatan">Kecamatan</option></select></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label><input type="number" wire:model="urutan" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                                <div class="flex items-end"><label class="inline-flex items-center"><input type="checkbox" wire:model="is_active" class="w-4 h-4 text-primary-600 border-gray-300 rounded"><span class="ml-2 text-sm text-gray-700">Aktif</span></label></div>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t bg-gray-50 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg">Batal</button>
                            <button type="submit" class="btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showDeleteModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6 text-center">
                    <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <h3 class="text-lg font-semibold mb-2">Hapus Prestasi?</h3>
                    <p class="text-gray-500 mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                    <div class="flex justify-center space-x-3">
                        <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg">Batal</button>
                        <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
