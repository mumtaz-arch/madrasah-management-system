<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Pengaturan Umum</h1>
            <p class="text-gray-500">Konfigurasi pengaturan global untuk sistem Madrasah Management</p>
        </div>
    </div>

    <!-- Feedback Message -->
    @if (session()->has('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-start">
            <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form wire:submit.prevent="save">
            <div class="p-6 md:p-8">
                
                <!-- Presensi RFID Section -->
                <div class="mb-10">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Konfigurasi Presensi RFID
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Mulai Presensi Masuk</label>
                            <p class="text-xs text-gray-500 mb-2">Jam awal mesin menerima absen kedatangan.</p>
                            <input type="time" wire:model="settings.rfid_checkin_start" class="w-full xl:w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.rfid_checkin_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Batas Waktu Terlambat</label>
                            <p class="text-xs text-gray-500 mb-2">Santri yang tap di atas jam ini akan berstatus "Terlambat".</p>
                            <input type="time" wire:model="settings.rfid_late_threshold" class="w-full xl:w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.rfid_late_threshold') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Akhir Presensi Masuk</label>
                            <p class="text-xs text-gray-500 mb-2">Jam penutupan mesin absen kedatangan.</p>
                            <input type="time" wire:model="settings.rfid_checkin_end" class="w-full xl:w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.rfid_checkin_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Mulai Presensi Pulang</label>
                            <p class="text-xs text-gray-500 mb-2">Jam awal mesin menerima absen kepulangan.</p>
                            <input type="time" wire:model="settings.rfid_checkout_start" class="w-full xl:w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.rfid_checkout_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Akhir Presensi Pulang</label>
                            <p class="text-xs text-gray-500 mb-2">Mesin menolak tap pulang di atas jam ini.</p>
                            <input type="time" wire:model="settings.rfid_checkout_end" class="w-full xl:w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.rfid_checkout_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200 mb-8">

                <!-- Kustomisasi Pesan Section -->
                <div class="mb-10">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        Pesan Umpan Balik Mesin RFID
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Sukses Tap Masuk</label>
                            <input type="text" wire:model="settings.msg_checkin_success" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.msg_checkin_success') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Sukses Tap Pulang</label>
                            <input type="text" wire:model="settings.msg_checkout_success" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.msg_checkout_success') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Kartu Belum Terdaftar</label>
                            <input type="text" wire:model="settings.msg_unregistered_card" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.msg_unregistered_card') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Di Luar Jam Operasional</label>
                            <input type="text" wire:model="settings.msg_outside_hours" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.msg_outside_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200 mb-8">

                <!-- Jurnal Guru Section -->
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Konfigurasi Jurnal Mengajar
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jam Buka Jurnal</label>
                            <p class="text-xs text-gray-500 mb-2">Jam paling awal Guru diperbolehkan mengisi jurnal.</p>
                            <input type="time" wire:model="settings.journal_open_time" class="w-full xl:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.journal_open_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Batas Akhir (Tutup) Jurnal</label>
                            <p class="text-xs text-gray-500 mb-2">Jam terakhir Guru diizinkan mengisi jurnal harian mereka.</p>
                            <input type="time" wire:model="settings.journal_close_time" class="w-full xl:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('settings.journal_close_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg shadow-sm transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
