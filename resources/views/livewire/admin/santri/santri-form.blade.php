<div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">{{ $isEdit ? 'Edit Santri' : 'Tambah Santri Baru' }}</h1>
            <p class="text-gray-500">{{ $isEdit ? 'Perbarui data santri' : 'Lengkapi form untuk menambah santri baru' }}</p>
        </div>
        <a href="{{ route('admin.santri.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Pribadi -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-heading font-semibold text-gray-900 mb-4">Data Pribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NIS -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIS <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="nis" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nis') border-red-500 @enderror">
                            @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- RFID UID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RFID UID (Opsional untuk Absensi)</label>
                            <input type="text" wire:model="rfid_uid" placeholder="Tap kartu di sini..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('rfid_uid') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Arahkan kursor ke sini lalu tap kartu ke reader.</p>
                            @error('rfid_uid') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- NISN -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                            <input type="text" wire:model="nisn" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('nisn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="nama_lengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_lengkap') border-red-500 @enderror">
                            @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                            <input type="text" wire:model="tempat_lahir" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" wire:model="tanggal_lahir" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select wire:model="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        
                        <!-- No HP -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                            <input type="text" wire:model="no_hp" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea wire:model="alamat" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Data Akademik -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-heading font-semibold text-gray-900 mb-4">Data Akademik</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kelas -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                            <select wire:model="kelas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} ({{ $kelas->tahun_ajaran }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Tahun Masuk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Masuk <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="tahun_masuk" min="2000" max="{{ date('Y') + 1 }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tahun_masuk') border-red-500 @enderror">
                            @error('tahun_masuk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Wali -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Wali Santri</label>
                            <select wire:model="wali_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Pilih Wali</option>
                                @foreach($waliList as $wali)
                                    <option value="{{ $wali->id }}">{{ $wali->nama_lengkap }} ({{ $wali->hubungan }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select wire:model="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="aktif">Aktif</option>
                                <option value="alumni">Alumni</option>
                                <option value="keluar">Keluar</option>
                                <option value="cuti">Cuti</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Akun Login -->
                @if(!$isEdit)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-heading font-semibold text-gray-900">Akun Login</h3>
                        <!-- Account creation is mandatory -->
                    </div>
                    
                    @if($createAccount)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" wire:model="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                            <input type="password" wire:model="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Foto -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-heading font-semibold text-gray-900 mb-4">Foto</h3>
                    <div class="text-center">
                        @if($foto && !is_string($foto))
                            <img src="{{ $foto->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                        @elseif($isEdit && $santri->foto)
                            <img src="{{ Storage::url($santri->foto) }}" class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <input type="file" wire:model="foto" accept="image/*" class="hidden" id="foto-upload">
                        <label for="foto-upload" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 cursor-pointer transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Pilih Foto
                        </label>
                        @error('foto') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        
                        <div wire:loading wire:target="foto" class="mt-2 text-sm text-gray-500">
                            Mengupload...
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <button type="submit" class="w-full py-3 px-6 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Santri' }}
                    </button>
                    
                    <a href="{{ route('admin.santri.index') }}" class="mt-3 w-full py-3 px-6 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
