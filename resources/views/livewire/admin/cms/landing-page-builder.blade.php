<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Page Builder</h1>
        <p class="text-gray-500">Kelola konten landing page dengan mudah tanpa coding.</p>
    </div>

    @if(session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="flex flex-wrap gap-2 mb-8 border-b border-gray-200 pb-4">
        @php $tabs = [
            'banner' => ['label' => 'Banner/Slider', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'],
            'hero' => ['label' => 'Hero', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>'],
            'statistik' => ['label' => 'Statistik', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>'],
            'program' => ['label' => 'Program Unggulan', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>'],
            'visi' => ['label' => 'Visi & Misi', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>'],
            'about' => ['label' => 'Tentang', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'],
            'contact' => ['label' => 'Kontak', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>'],
            'social' => ['label' => 'Sosial Media', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>'],
            'map' => ['label' => 'Google Map', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 4m0 16l6-3m-6 3v-13m6 13l5.447 2.724A1 1 0 0021 20.382V9.618a1 1 0 00-.553-.894L15 6m0 14V6m0 0L9 4"></path></svg>'],
            'footer' => ['label' => 'Footer', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>'],
            'favicon' => ['label' => 'Favicon', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>'],
            'testimoni' => ['label' => 'Testimoni', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>'],
            'prestasi' => ['label' => 'Prestasi', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>'],
            'guru' => ['label' => 'Guru', 'icon' => '<svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'],
        ]; @endphp
        @foreach($tabs as $key => $tab)
        <button wire:click="$set('activeTab', '{{ $key }}')" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition-all text-sm {{ $activeTab === $key ? 'bg-primary-600 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900 border border-gray-100/50' }}">
            {!! $tab['icon'] !!} <span class="whitespace-nowrap">{{ $tab['label'] }}</span>
        </button>
        @endforeach
    </div>

    <!-- Tab Content -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- HERO TAB -->
        @if($activeTab === 'hero')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Bagian Hero</h2>
                        <p class="text-gray-500 text-sm">Bagian pertama yang dilihat pengunjung</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Judul Utama</label>
                            <input type="text" wire:model="heroTitle" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="Contoh: Mewujudkan Generasi Rabbani">
                            <p class="mt-1 text-xs text-gray-400">Teks besar yang muncul di tengah hero</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Sub Judul</label>
                            <textarea wire:model="heroSubtitle" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="Deskripsi singkat pesantren..."></textarea>
                            <p class="mt-1 text-xs text-gray-400">Teks kecil di bawah judul utama</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Latar Belakang</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary-500 transition-colors">
                                <input type="file" wire:model="newHeroImage" accept="image/*" class="hidden" id="heroImageInput">
                                <label for="heroImageInput" class="cursor-pointer">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <span class="text-primary-600 font-semibold">Klik untuk upload gambar</span>
                                    <p class="text-gray-400 text-sm mt-1">PNG, JPG hingga 5MB</p>
                                </label>
                            </div>
                            @if($newHeroImage)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-green-600 mb-2">Preview Gambar Baru:</p>
                                    <img src="{{ $newHeroImage->temporaryUrl() }}" class="w-full h-48 object-cover rounded-xl">
                                </div>
                            @elseif($heroImage)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-600 mb-2">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/'.$heroImage) }}" class="w-full h-48 object-cover rounded-xl">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-xl p-6 flex flex-col justify-center items-center text-center">
                        <p class="text-gray-400 text-xs uppercase tracking-wide mb-4">Preview Hero</p>
                        <div class="bg-gray-800/50 p-8 rounded-xl w-full">
                            <h3 class="text-2xl font-bold text-white mb-3">{{ $heroTitle ?: 'Judul Utama' }}</h3>
                            <p class="text-gray-300 text-sm">{{ $heroSubtitle ?: 'Sub judul akan tampil di sini...' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <button wire:click="saveHero" wire:loading.attr="disabled" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all flex items-center gap-2">
                        <svg wire:loading wire:target="saveHero" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <svg wire:loading.remove wire:target="saveHero" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Hero
                    </button>
                </div>
            </div>
        @endif

        <!-- ABOUT TAB -->
        @if($activeTab === 'about')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Bagian Tentang Kami</h2>
                        <p class="text-gray-500 text-sm">Informasi tentang pesantren</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Section</label>
                        <input type="text" wire:model="aboutTitle" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                        <textarea wire:model="aboutText" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Gambar</label>
                        <input type="file" wire:model="newAboutImage" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                        @if($newAboutImage)
                            <img src="{{ $newAboutImage->temporaryUrl() }}" class="mt-4 w-64 h-40 object-cover rounded-xl">
                        @elseif($aboutImage)
                            <img src="{{ asset('storage/'.$aboutImage) }}" class="mt-4 w-64 h-40 object-cover rounded-xl">
                        @endif
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <button wire:click="saveAbout" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">
                        Simpan Tentang Kami
                    </button>
                </div>
            </div>
        @endif

        <!-- CONTACT TAB -->
        @if($activeTab === 'contact')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Informasi Kontak</h2>
                        <p class="text-gray-500 text-sm">Detail kontak yang ditampilkan di footer</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea wire:model="contactAddress" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"></textarea>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" wire:model="contactPhone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" wire:model="contactEmail" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <button wire:click="saveContact" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">
                        Simpan Kontak
                    </button>
                </div>
            </div>
        @endif

        <!-- SOCIAL TAB -->
        @if($activeTab === 'social')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Link Sosial Media</h2>
                        <p class="text-gray-500 text-sm">Link ke akun sosial media pesantren</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl">
                        <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Facebook</label>
                            <input type="url" wire:model="socialFacebook" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" placeholder="https://facebook.com/...">
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-pink-50 rounded-xl">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 text-white flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/></svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Instagram</label>
                            <input type="url" wire:model="socialInstagram" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" placeholder="https://instagram.com/...">
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-red-50 rounded-xl">
                        <div class="w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">YouTube</label>
                            <input type="url" wire:model="socialYoutube" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" placeholder="https://youtube.com/...">
                        </div>
                    </div>
                </div>

                    <div class="flex items-center gap-4 p-4 bg-green-50 rounded-xl">
                        <div class="w-12 h-12 rounded-full bg-green-500 text-white flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">WhatsApp (Nomor)</label>
                            <input type="text" wire:model="socialWhatsapp" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" placeholder="6281234567890">
                            <p class="text-xs text-gray-400 mt-1">Format: 628xxx (tanpa + atau spasi). Akan muncul sebagai tombol floating WA.</p>
                        </div>
                    </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <button wire:click="saveSocial" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">
                        Simpan Sosial Media
                    </button>
                </div>
            </div>
        @endif

        <!-- FOOTER TAB -->
        @if($activeTab === 'footer')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-gray-700 text-white flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Bagian Footer</h2>
                        <p class="text-gray-500 text-sm">Teks dan informasi di bagian bawah website</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Teks Footer</label>
                    <textarea wire:model="footerText" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="Deskripsi singkat tentang pesantren..."></textarea>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <button wire:click="saveFooter" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">
                        Simpan Footer
                    </button>
                </div>
            </div>
        @endif

        <!-- FAVICON TAB -->
        @if($activeTab === 'favicon')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Favicon</h2>
                        <p class="text-gray-500 text-sm">Ikon kecil yang muncul di tab browser</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload Favicon</label>
                        <p class="text-xs text-gray-500 mb-3">Rekomendasi: PNG/ICO, ukuran 32x32 atau 64x64 pixel</p>
                        <input type="file" wire:model="newFavicon" accept="image/*,.ico" class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                        @if($newFavicon)
                            <div class="mt-4 flex items-center gap-4">
                                <img src="{{ $newFavicon->temporaryUrl() }}" class="w-16 h-16 object-contain bg-gray-100 rounded-lg p-2">
                                <span class="text-green-600 font-medium">Preview Favicon Baru</span>
                            </div>
                        @elseif($favicon)
                            <div class="mt-4 flex items-center gap-4">
                                <img src="{{ asset('storage/'.$favicon) }}" class="w-16 h-16 object-contain bg-gray-100 rounded-lg p-2">
                                <span class="text-gray-600">Favicon Saat Ini</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <button wire:click="saveFavicon" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">
                        Simpan Favicon
                    </button>
                </div>
            </div>
        @endif

        <!-- TESTIMONI TAB -->
        @if($activeTab === 'testimoni')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Testimoni</h2>
                        <p class="text-gray-500 text-sm">Kelola testimoni yang ditampilkan di landing page</p>
                    </div>
                </div>

                <!-- Add New Testimoni -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Tambah Testimoni Baru</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" wire:model="newTestimonialName" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Nama lengkap">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan/Peran</label>
                            <input type="text" wire:model="newTestimonialRole" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Contoh: Wali Santri">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Testimoni</label>
                        <textarea wire:model="newTestimonialText" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Isi testimoni..."></textarea>
                    </div>
                    <button wire:click="addTestimonial" class="mt-4 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        Tambah Testimoni
                    </button>
                </div>

                <!-- List Testimoni -->
                <div class="space-y-4">
                    @forelse($testimonials as $index => $testimonial)
                        <div class="flex items-start gap-4 p-4 bg-white border border-gray-200 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg shrink-0">
                                {{ strtoupper(substr($testimonial['name'], 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $testimonial['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $testimonial['role'] ?? '-' }}</p>
                                <p class="text-gray-600 mt-2">{{ $testimonial['text'] }}</p>
                            </div>
                            <button wire:click="removeTestimonial({{ $index }})" class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            <p>Belum ada testimoni</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- PRESTASI TAB -->
        @if($activeTab === 'prestasi')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Prestasi</h2>
                        <p class="text-gray-500 text-sm">Kelola prestasi yang ditampilkan di landing page</p>
                    </div>
                </div>

                <!-- Add New Prestasi -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Tambah Prestasi Baru</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Prestasi</label>
                            <input type="text" wire:model="newAchievementTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Contoh: Juara 1 Olimpiade Matematika">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <input type="text" wire:model="newAchievementYear" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="2024">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                        <textarea wire:model="newAchievementDesc" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Deskripsi singkat..."></textarea>
                    </div>
                    <button wire:click="addAchievement" class="mt-4 px-6 py-2 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors">
                        Tambah Prestasi
                    </button>
                </div>

                <!-- List Prestasi -->
                <div class="space-y-4">
                    @forelse($achievements as $index => $achievement)
                        <div class="flex items-start gap-4 p-4 bg-white border border-gray-200 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $achievement['title'] }}</p>
                                <p class="text-sm text-amber-600 font-medium">{{ $achievement['year'] ?? '-' }}</p>
                                @if(!empty($achievement['description']))
                                    <p class="text-gray-600 mt-1 text-sm">{{ $achievement['description'] }}</p>
                                @endif
                            </div>
                            <button wire:click="removeAchievement({{ $index }})" class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            <p>Belum ada prestasi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- PROGRAM TAB -->
        @if($activeTab === 'program')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Program Unggulan</h2>
                        <p class="text-gray-500 text-sm">Kelola daftar program unggulan pesantren</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Form -->
                    <div class="lg:col-span-1 bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4">{{ $editingProgramId ? 'Edit Program' : 'Tambah Program Baru' }}</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Program</label>
                                <input type="text" wire:model="programTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                                <textarea wire:model="programDescription" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ikon (Heroicons)</label>
                                <input type="text" wire:model="programIcon" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Contoh: book-open">
                                <p class="text-xs text-gray-500 mt-1">Gunakan ikon dari heroicons.com</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar (Opsional)</label>
                                @if($programImage && !$newProgramImage)
                                    <div class="mb-2 relative w-full h-32 rounded-lg overflow-hidden border border-gray-200">
                                        <img src="{{ asset('storage/' . $programImage) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                @if($newProgramImage)
                                    <div class="mb-2 relative w-full h-32 rounded-lg overflow-hidden border border-gray-200">
                                        <img src="{{ $newProgramImage->temporaryUrl() }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <input type="file" wire:model="newProgramImage" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                <div wire:loading wire:target="newProgramImage" class="text-sm text-primary-600 mt-1">Mengupload...</div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                                    <input type="number" wire:model="programSortOrder" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div class="flex items-end pb-2">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="programIsFeatured" class="sr-only peer">
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-700">Tampilkan</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col gap-2">
                            <button wire:click="saveProgram" class="w-full px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                                Simpan Program
                            </button>
                            @if($editingProgramId)
                                <button wire:click="resetProgramForm" class="w-full px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                                    Batal Edit
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- List -->
                    <div class="lg:col-span-2 space-y-4">
                        @forelse($programs as $program)
                            <div class="flex bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                @if(!empty($program['image']))
                                    <div class="w-32 h-32 shrink-0 border-r border-gray-100">
                                        <img src="{{ asset('storage/' . $program['image']) }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-32 h-32 shrink-0 bg-primary-50 flex items-center justify-center text-primary-300 border-r border-gray-100">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                @endif
                                
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-bold text-gray-800 text-lg">{{ $program['title'] }}</h3>
                                                <div class="flex items-center gap-2 mt-1">
                                                    @if($program['is_featured'])
                                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded">Aktif</span>
                                                    @else
                                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded">Draft</span>
                                                    @endif
                                                    <span class="text-xs text-gray-500">Urutan: {{ $program['sort_order'] ?? 0 }}</span>
                                                    @if(!empty($program['icon']))
                                                        <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600 font-mono">{{ $program['icon'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 shrink-0 ml-2">
                                                <button wire:click="editProgram({{ $program['id'] }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <button wire:click="deleteProgram({{ $program['id'] }})" wire:confirm="Yakin hapus program ini?" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <p class="text-gray-600 text-sm mt-3 line-clamp-2">{{ $program['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p class="text-gray-500">Belum ada program unggulan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        <!-- GURU TAB -->
        @if($activeTab === 'guru')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Guru/Asatidz</h2>
                        <p class="text-gray-500 text-sm">Pilih guru yang ditampilkan di landing page</p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <p class="text-blue-800 text-sm">
                        <strong>Info:</strong> Data guru diambil dari menu Data Guru di Akademik. Pilih guru yang ingin ditampilkan di landing page.
                    </p>
                </div>

                <!-- Guru Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($allGuru as $guru)
                        <label class="flex items-center gap-4 p-4 bg-white border-2 rounded-xl cursor-pointer transition-colors {{ in_array($guru->id, $selectedGuruIds) ? 'border-teal-500 bg-teal-50' : 'border-gray-200 hover:bg-gray-50' }}">
                            <input type="checkbox" wire:model="selectedGuruIds" value="{{ $guru->id }}" class="w-5 h-5 text-teal-600 rounded">
                            <div class="flex items-center gap-3 flex-1">
                                @if($guru->foto)
                                    <img src="{{ asset('storage/'.$guru->foto) }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold">
                                        {{ strtoupper(substr($guru->nama, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $guru->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $guru->jabatan ?? 'Guru' }}</p>
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-400">
                            <p>Belum ada data guru. Tambahkan guru di menu Data Guru.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <button wire:click="saveSelectedGuru" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">
                        Simpan Pilihan Guru ({{ count($selectedGuruIds) }} dipilih)
                    </button>
                </div>
            </div>
        @endif

        <!-- STATISTIK TAB -->
        @if($activeTab === 'statistik')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">📊</div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Statistik</h2>
                        <p class="text-gray-500 text-sm">Angka-angka yang ditampilkan di landing page</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Santri</label><input type="text" wire:model="statSantri" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500" placeholder="500+"></div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Alumni</label><input type="text" wire:model="statAlumni" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500" placeholder="1.200+"></div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Pendidik</label><input type="text" wire:model="statPengajar" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500" placeholder="45+"></div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Akreditasi</label><input type="text" wire:model="statAkreditasi" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500" placeholder="A"></div>
                </div>
                <div class="mt-8 pt-6 border-t border-gray-200"><button wire:click="saveStatistics" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">Simpan Statistik</button></div>
            </div>
        @endif

        <!-- VISI TAB -->
        @if($activeTab === 'visi')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">🕌</div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Visi & Misi</h2>
                        <p class="text-gray-500 text-sm">Teks visi/quote yang ditampilkan di section hijau</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Teks Visi / Quote</label><textarea wire:model="visionText" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500"></textarea></div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Sub Teks (label kecil di bawah)</label><input type="text" wire:model="visionSubtext" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500" placeholder="Visi Pondok Pesantren Pancasila Reo"></div>
                </div>
                <div class="mt-8 pt-6 border-t border-gray-200"><button wire:click="saveVision" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">Simpan Visi & Misi</button></div>
            </div>
        @endif

        <!-- BANNER TAB -->
        @if($activeTab === 'banner')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">🖼️</div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Hero Slider / Banner</h2>
                        <p class="text-gray-500 text-sm">Kelola slide yang tampil di hero section</p>
                    </div>
                </div>
                <!-- Add/Edit Banner Form -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">{{ $editingBannerId ? 'Edit Banner' : 'Tambah Banner Baru' }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Judul</label><input type="text" wire:model="bannerTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Judul slide"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label><input type="number" wire:model="bannerSortOrder" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="0"></div>
                    </div>
                    <div class="mt-4"><label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label><textarea wire:model="bannerSubtitle" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Deskripsi slide"></textarea></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Teks Tombol CTA</label><input type="text" wire:model="bannerCtaText" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="DAFTAR SANTRI BARU 2026/2027"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Link CTA</label><input type="text" wire:model="bannerCtaLink" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="/ppdb"></div>
                    </div>
                    <div class="mt-4"><label class="block text-sm font-medium text-gray-700 mb-1">Gambar Background</label><input type="file" wire:model="bannerImage" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-xl"><p class="text-xs text-gray-400 mt-1">Rekomendasi: 1920x1080px, format JPG/PNG</p></div>
                    <div class="flex gap-3 mt-4">
                        <button wire:click="saveBanner" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">{{ $editingBannerId ? 'Perbarui' : 'Tambah' }} Banner</button>
                        @if($editingBannerId)<button wire:click="resetBannerForm" class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300">Batal</button>@endif
                    </div>
                </div>
                <!-- Banner List -->
                <div class="space-y-4">
                    @forelse($banners as $banner)
                        <div class="flex items-center gap-4 p-4 bg-white border border-gray-200 rounded-xl">
                            @if(!empty($banner['image']))<img src="{{ asset('storage/'.$banner['image']) }}" class="w-24 h-16 object-cover rounded-lg">@else<div class="w-24 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>@endif
                            <div class="flex-1"><p class="font-semibold text-gray-800">{{ $banner['title'] }}</p><p class="text-sm text-gray-500">{{ Str::limit($banner['subtitle'] ?? '', 60) }}</p></div>
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded">Order: {{ $banner['sort_order'] }}</span>
                            <button wire:click="editBanner({{ $banner['id'] }})" class="text-blue-600 hover:text-blue-800 p-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                            <button wire:click="deleteBanner({{ $banner['id'] }})" wire:confirm="Hapus banner ini?" class="text-red-500 hover:text-red-700 p-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400"><p>Belum ada banner. Tambahkan banner untuk mengaktifkan hero slider.</p></div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- MAP TAB -->
        @if($activeTab === 'map')
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">🗺️</div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Google Map</h2>
                        <p class="text-gray-500 text-sm">Embed peta lokasi pesantren di footer</p>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">URL Embed Google Maps</label>
                    <input type="url" wire:model="mapEmbed" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500" placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="text-xs text-gray-400 mt-2">Buka Google Maps → Cari lokasi → Klik Share → Embed a map → Copy URL dari src="..."</p>
                    @if($mapEmbed)
                    <div class="mt-4 rounded-xl overflow-hidden border border-gray-200 h-64"><iframe src="{{ $mapEmbed }}" width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"></iframe></div>
                    @endif
                </div>
                <div class="mt-8 pt-6 border-t border-gray-200"><button wire:click="saveMap" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg transition-all">Simpan Google Map</button></div>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 p-6 bg-gradient-to-r from-primary-50 to-secondary-50 rounded-2xl border border-primary-100">
        <h3 class="font-bold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="flex flex-wrap gap-4">
            <a href="/" target="_blank" class="px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl hover:bg-gray-50 shadow-sm transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Lihat Website
            </a>
            <button wire:click="loadAllContent" class="px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl hover:bg-gray-50 shadow-sm transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh Data
            </button>
        </div>
    </div>
</div>
