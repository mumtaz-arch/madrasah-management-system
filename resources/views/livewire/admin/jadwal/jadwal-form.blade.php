<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">{{ $isEdit ? 'Edit Jadwal' : 'Tambah Jadwal Baru' }}</h1>
            <p class="text-gray-500">{{ $isEdit ? 'Perbarui jadwal pelajaran' : 'Lengkapi form untuk menambah jadwal baru' }}</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form wire:submit="save">
        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <!-- Kelas & Mapel -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                        <select wire:model="kelas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kelas_id') border-red-500 @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} ({{ $kelas->tahun_ajaran }})</option>
                            @endforeach
                        </select>
                        @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran <span class="text-red-500">*</span></label>
                        <select wire:model="mapel_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('mapel_id') border-red-500 @enderror">
                            <option value="">Pilih Mapel</option>
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama }} ({{ $mapel->kode }})</option>
                            @endforeach
                        </select>
                        @error('mapel_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <!-- Guru -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guru Pengajar <span class="text-red-500">*</span></label>
                    <select wire:model="guru_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('guru_id') border-red-500 @enderror">
                        <option value="">Pilih Guru</option>
                        @foreach($guruList as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama_lengkap }} - {{ $guru->bidang_keahlian ?? 'Guru' }}</option>
                        @endforeach
                    </select>
                    @error('guru_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Hari & Waktu -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hari <span class="text-red-500">*</span></label>
                        <select wire:model="hari" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" wire:model="jam_mulai" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('jam_mulai') border-red-500 @enderror">
                        @error('jam_mulai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                        <input type="time" wire:model="jam_selesai" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('jam_selesai') border-red-500 @enderror">
                        @error('jam_selesai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <!-- Tahun Ajaran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="tahun_ajaran" placeholder="2024/2025" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tahun_ajaran') border-red-500 @enderror">
                    @error('tahun_ajaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div class="flex items-center space-x-4 pt-4">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Jadwal' }}
                    </button>
                    <a href="{{ route('admin.jadwal.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
