<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">{{ $isEdit ? 'Edit Kelas' : 'Tambah Kelas Baru' }}</h1>
            <p class="text-gray-500">{{ $isEdit ? 'Perbarui data kelas' : 'Lengkapi form untuk menambah kelas baru' }}</p>
        </div>
        <a href="{{ route('admin.kelas.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
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
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nama_kelas" placeholder="Contoh: VII A" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_kelas') border-red-500 @enderror">
                        @error('nama_kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat <span class="text-red-500">*</span></label>
                        <select wire:model="tingkat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="7">Tingkat 7 (SMP Kelas 1)</option>
                            <option value="8">Tingkat 8 (SMP Kelas 2)</option>
                            <option value="9">Tingkat 9 (SMP Kelas 3)</option>
                            <option value="10">Tingkat 10 (SMA Kelas 1)</option>
                            <option value="11">Tingkat 11 (SMA Kelas 2)</option>
                            <option value="12">Tingkat 12 (SMA Kelas 3)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="tahun_ajaran" placeholder="2024/2025" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tahun_ajaran') border-red-500 @enderror">
                        @error('tahun_ajaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
                        <select wire:model="wali_kelas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Pilih Wali Kelas</option>
                            @foreach($guruList as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama_lengkap }} - {{ $guru->bidang_keahlian ?? $guru->jabatan ?? 'Guru' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex items-center space-x-4">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Kelas' }}
                    </button>
                    <a href="{{ route('admin.kelas.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
