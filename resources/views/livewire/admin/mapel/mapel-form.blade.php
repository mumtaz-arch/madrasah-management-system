<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">{{ $isEdit ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran Baru' }}</h1>
            <p class="text-gray-500">{{ $isEdit ? 'Perbarui data mapel' : 'Lengkapi form untuk menambah mapel baru' }}</p>
        </div>
        <a href="{{ route('admin.mapel.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form wire:submit="save">
        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Mapel <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="kode" placeholder="Contoh: MTK" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 uppercase @error('kode') border-red-500 @enderror">
                        @error('kode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select wire:model="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="umum">Umum</option>
                            <option value="diniyah">Diniyah</option>
                            <option value="tahfidz">Tahfidz</option>
                            <option value="bahasa">Bahasa</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Pelajaran <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nama" placeholder="Contoh: Matematika" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama') border-red-500 @enderror">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">KKM (Kriteria Ketuntasan Minimal) <span class="text-red-500">*</span></label>
                        <input type="number" wire:model="kkm" min="0" max="100" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kkm') border-red-500 @enderror">
                        @error('kkm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex items-center space-x-4">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Mapel' }}
                    </button>
                    <a href="{{ route('admin.mapel.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
