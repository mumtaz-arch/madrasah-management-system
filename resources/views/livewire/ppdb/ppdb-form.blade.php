<div class="max-w-3xl mx-auto">
    @if(!$submitted)
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                @foreach([1 => 'Data Pribadi', 2 => 'Orang Tua', 3 => 'Pendidikan', 4 => 'Dokumen'] as $num => $label)
                    <div class="flex items-center {{ $num < 4 ? 'flex-1' : '' }}">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full font-bold text-sm
                            {{ $step >= $num ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                            @if($step > $num)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                {{ $num }}
                            @endif
                        </div>
                        <span class="ml-2 text-xs font-medium {{ $step >= $num ? 'text-primary-600' : 'text-gray-500' }} hidden sm:block">{{ $label }}</span>
                        @if($num < 4)
                            <div class="flex-1 mx-2 h-1 rounded {{ $step > $num ? 'bg-primary-600' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
            <!-- Step 1: Data Pribadi -->
            @if($step === 1)
                <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">Data Pribadi Calon Santri</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nama_lengkap" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_lengkap') border-red-500 @enderror" placeholder="Masukkan nama lengkap">
                        @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="tempat_lahir" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tempat_lahir') border-red-500 @enderror">
                            @error('tempat_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" wire:model="tanggal_lahir" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tanggal_lahir') border-red-500 @enderror">
                            @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" wire:model="jenis_kelamin" value="L" class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-gray-700">Laki-laki</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model="jenis_kelamin" value="P" class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-gray-700">Perempuan</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                        <textarea wire:model="alamat" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('alamat') border-red-500 @enderror" placeholder="Alamat lengkap"></textarea>
                        @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="no_hp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('no_hp') border-red-500 @enderror" placeholder="08xxxxxxxxxx">
                            @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" wire:model="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror" placeholder="email@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 2: Data Orang Tua -->
            @if($step === 2)
                <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">Data Orang Tua / Wali</h2>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="nama_ayah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_ayah') border-red-500 @enderror">
                            @error('nama_ayah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="nama_ibu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_ibu') border-red-500 @enderror">
                            @error('nama_ibu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                            <input type="text" wire:model="pekerjaan_ayah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                            <input type="text" wire:model="pekerjaan_ibu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Orang Tua <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="no_hp_ortu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('no_hp_ortu') border-red-500 @enderror" placeholder="08xxxxxxxxxx">
                        <p class="text-xs text-gray-500 mt-1">Nomor ini akan digunakan untuk komunikasi via WhatsApp</p>
                        @error('no_hp_ortu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            @endif

            <!-- Step 3: Pendidikan -->
            @if($step === 3)
                <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">Data Pendidikan</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asal Sekolah (SD/MI) <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="asal_sekolah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('asal_sekolah') border-red-500 @enderror" placeholder="Nama sekolah asal">
                        @error('asal_sekolah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
                            <input type="text" wire:model="tahun_lulus" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="{{ date('Y') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                            <input type="text" wire:model="nisn" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Opsional">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 4: Upload Dokumen -->
            @if($step === 4)
                <h2 class="font-heading text-xl font-bold text-gray-900 mb-2">Upload Dokumen</h2>
                <p class="text-gray-500 text-sm mb-6">Upload dokumen berikut dalam format PDF, JPG, atau PNG (maks. 2MB per file)</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kartu Keluarga -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100 @error('file_kk') ring-2 ring-red-400 @enderror">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm">Kartu Keluarga (KK)</h3>
                                <p class="text-xs text-gray-500">Wajib diisi</p>
                            </div>
                        </div>
                        <label class="block">
                            <input type="file" wire:model="file_kk" accept=".pdf,.jpg,.jpeg,.png" class="hidden" id="file_kk">
                            <div class="border-2 border-dashed border-blue-200 rounded-lg p-3 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition-colors">
                                @if($file_kk)
                                    <div class="flex items-center justify-center space-x-2 text-green-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium truncate max-w-[150px]">{{ $file_kk->getClientOriginalName() }}</span>
                                    </div>
                                @else
                                    <svg class="w-8 h-8 mx-auto text-blue-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-xs text-gray-500">Klik untuk upload</p>
                                @endif
                            </div>
                        </label>
                        @error('file_kk') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Akta Kelahiran -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-100 @error('file_akta') ring-2 ring-red-400 @enderror">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm">Akta Kelahiran</h3>
                                <p class="text-xs text-gray-500">Wajib diisi</p>
                            </div>
                        </div>
                        <label class="block">
                            <input type="file" wire:model="file_akta" accept=".pdf,.jpg,.jpeg,.png" class="hidden" id="file_akta">
                            <div class="border-2 border-dashed border-purple-200 rounded-lg p-3 text-center cursor-pointer hover:border-purple-400 hover:bg-purple-50/50 transition-colors">
                                @if($file_akta)
                                    <div class="flex items-center justify-center space-x-2 text-green-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium truncate max-w-[150px]">{{ $file_akta->getClientOriginalName() }}</span>
                                    </div>
                                @else
                                    <svg class="w-8 h-8 mx-auto text-purple-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-xs text-gray-500">Klik untuk upload</p>
                                @endif
                            </div>
                        </label>
                        @error('file_akta') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Ijazah/SKL -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-100 @error('file_ijazah') ring-2 ring-red-400 @enderror">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm">Ijazah / SKL</h3>
                                <p class="text-xs text-gray-500">Wajib diisi</p>
                            </div>
                        </div>
                        <label class="block">
                            <input type="file" wire:model="file_ijazah" accept=".pdf,.jpg,.jpeg,.png" class="hidden" id="file_ijazah">
                            <div class="border-2 border-dashed border-amber-200 rounded-lg p-3 text-center cursor-pointer hover:border-amber-400 hover:bg-amber-50/50 transition-colors">
                                @if($file_ijazah)
                                    <div class="flex items-center justify-center space-x-2 text-green-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium truncate max-w-[150px]">{{ $file_ijazah->getClientOriginalName() }}</span>
                                    </div>
                                @else
                                    <svg class="w-8 h-8 mx-auto text-amber-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-xs text-gray-500">Klik untuk upload</p>
                                @endif
                            </div>
                        </label>
                        @error('file_ijazah') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- KTP Orang Tua -->
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-4 border border-teal-100 @error('file_ktp_ortu') ring-2 ring-red-400 @enderror">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-teal-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm">KTP Orang Tua/Wali</h3>
                                <p class="text-xs text-gray-500">Wajib diisi</p>
                            </div>
                        </div>
                        <label class="block">
                            <input type="file" wire:model="file_ktp_ortu" accept=".pdf,.jpg,.jpeg,.png" class="hidden" id="file_ktp_ortu">
                            <div class="border-2 border-dashed border-teal-200 rounded-lg p-3 text-center cursor-pointer hover:border-teal-400 hover:bg-teal-50/50 transition-colors">
                                @if($file_ktp_ortu)
                                    <div class="flex items-center justify-center space-x-2 text-green-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium truncate max-w-[150px]">{{ $file_ktp_ortu->getClientOriginalName() }}</span>
                                    </div>
                                @else
                                    <svg class="w-8 h-8 mx-auto text-teal-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-xs text-gray-500">Klik untuk upload</p>
                                @endif
                            </div>
                        </label>
                        @error('file_ktp_ortu') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Pas Foto (Full Width) -->
                <div class="mt-4 bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-4 border border-emerald-100 @error('file_pas_foto') ring-2 ring-red-400 @enderror">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 text-sm">Pas Foto (3x4)</h3>
                            <p class="text-xs text-gray-500">Format JPG/PNG, latar belakang merah atau biru</p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <label class="flex-1 block w-full">
                            <input type="file" wire:model="file_pas_foto" accept=".jpg,.jpeg,.png" class="hidden" id="file_pas_foto">
                            <div class="border-2 border-dashed border-emerald-200 rounded-lg p-4 text-center cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/50 transition-colors">
                                <svg class="w-10 h-10 mx-auto text-emerald-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <p class="text-sm text-gray-600">Klik untuk upload pas foto</p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG (maks. 2MB)</p>
                            </div>
                        </label>
                        @if($file_pas_foto)
                            <div class="flex-shrink-0 text-center">
                                <p class="text-xs text-green-600 mb-2 font-medium">Preview Foto:</p>
                                <img src="{{ $file_pas_foto->temporaryUrl() }}" class="w-24 h-32 object-cover rounded-lg border-2 border-emerald-300 shadow-md mx-auto">
                            </div>
                        @endif
                    </div>
                    @error('file_pas_foto') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="mt-8 flex items-center justify-between">
                @if($step > 1)
                    <button wire:click="prevStep" type="button" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                        Kembali
                    </button>
                @else
                    <div></div>
                @endif
                
                @if($step < 4)
                    <button wire:click="nextStep" type="button" class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                        Lanjut
                    </button>
                @else
                    <button wire:click="submit" type="button" class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submit">Kirim Pendaftaran</span>
                        <span wire:loading wire:target="submit" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengunggah...
                        </span>
                    </button>
                @endif
            </div>
        </div>
    @else
        <!-- Success State -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 text-center">
            <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h2 class="font-heading text-2xl font-bold text-gray-900 mb-2">Pendaftaran Berhasil!</h2>
            <p class="text-gray-500 mb-6">Terima kasih telah mendaftar di Pondok Pesantren Pancasila Reo</p>
            
            <div class="bg-primary-50 rounded-xl p-6 mb-6">
                <p class="text-sm text-primary-700 mb-2">Nomor Registrasi Anda:</p>
                <p class="text-3xl font-bold text-primary-600 font-mono">{{ $noRegistrasi }}</p>
            </div>
            
            <p class="text-sm text-gray-500 mb-6">
                Simpan nomor registrasi ini untuk mengecek status pendaftaran Anda.
                <br>Tim kami akan menghubungi Anda melalui WhatsApp di nomor HP yang terdaftar.
            </p>
            
            <a href="{{ route('ppdb') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                Kembali ke Halaman PPDB
            </a>
        </div>
    @endif
</div>
