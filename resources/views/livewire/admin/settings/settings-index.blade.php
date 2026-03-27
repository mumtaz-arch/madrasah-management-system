<div>
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 border whitespace-pre-wrap border-green-200 text-green-700 rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="font-heading text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
                <p class="text-gray-500">Konfigurasi sistem dan informasi pesantren</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-6" x-data="{ activeTab: 'pesantren' }">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8">
                    <button type="button" @click="activeTab = 'pesantren'" 
                            :class="activeTab === 'pesantren' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Informasi Pesantren
                    </button>
                    <button type="button" @click="activeTab = 'ppdb'" 
                            :class="activeTab === 'ppdb' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Pengaturan PPDB
                    </button>
                    <button type="button" @click="activeTab = 'tahun'" 
                            :class="activeTab === 'tahun' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Tahun Ajaran
                    </button>
                </nav>
            </div>

        <!-- Tab Content: Informasi Pesantren -->
        <div x-show="activeTab === 'pesantren'" class="mt-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Informasi Pesantren
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pesantren</label>
                            <input type="text" wire:model.defer="nama_pesantren" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Singkat</label>
                            <input type="text" wire:model.defer="nama_singkat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea rows="3" wire:model.defer="alamat_lengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                            <input type="text" wire:model.defer="no_telepon" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                            <input type="text" wire:model.defer="whatsapp" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" wire:model.defer="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pimpinan</label>
                            <input type="text" wire:model.defer="nama_pimpinan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Berdiri</label>
                            <input type="text" wire:model.defer="tahun_berdiri" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Visi Pesantren</label>
                        <textarea rows="2" wire:model.defer="visi_pesantren" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Misi Pesantren</label>
                        <textarea rows="3" wire:model.defer="misi_pesantren" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content: Pengaturan PPDB -->
        <div x-show="activeTab === 'ppdb'" class="mt-6" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Pengaturan PPDB
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Status Toggle -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Status Pendaftaran PPDB</h4>
                            <p class="text-sm text-gray-500">Buka atau tutup pendaftaran PPDB online</p>
                        </div>
                        <div class="flex items-center">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.defer="ppdb_status" class="sr-only peer">
                                <div class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                                <span class="ms-3 text-sm font-bold text-gray-700">{{ $ppdb_status ? 'Dibuka' : 'Ditutup' }}</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran PPDB</label>
                            <input type="text" wire:model.defer="ppdb_tahun_ajaran" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kuota Pendaftaran</label>
                            <input type="number" wire:model.defer="ppdb_kuota" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai Pendaftaran</label>
                            <input type="date" wire:model.defer="ppdb_start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai Pendaftaran</label>
                            <input type="date" wire:model.defer="ppdb_end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Pendaftaran</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="text" wire:model.defer="ppdb_biaya" class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Informasi Tambahan PPDB</label>
                        <textarea rows="3" wire:model.defer="ppdb_info" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content: Tahun Ajaran -->
        <div x-show="activeTab === 'tahun'" class="mt-6" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Tahun Ajaran
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Current Year -->
                        <div class="flex items-center justify-between p-4 bg-primary-50 border border-primary-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">2024/2025</p>
                                    <p class="text-sm text-gray-500">Semester Ganjil</p>
                                </div>
                            </div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-primary-100 text-primary-700">Aktif</span>
                        </div>
                        
                        <!-- Previous Years -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">2023/2024</p>
                                    <p class="text-sm text-gray-500">Selesai</p>
                                </div>
                            </div>
                            <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-600">Arsip</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">2022/2023</p>
                                    <p class="text-sm text-gray-500">Selesai</p>
                                </div>
                            </div>
                            <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-600">Arsip</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Save Button -->
        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
