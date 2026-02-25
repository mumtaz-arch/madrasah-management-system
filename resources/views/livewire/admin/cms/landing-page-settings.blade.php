<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6 text-primary-600">Pengaturan Landing Page</h2>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="save" class="space-y-8">
                    
                    <!-- Hero Section -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
                            <span class="mr-2">🖼️</span> Hero Section (Banner Utama)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama</label>
                                <input type="text" wire:model="settings.hero_title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Judul</label>
                                <textarea wire:model="settings.hero_subtitle" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teks Tombol (CTA)</label>
                                <input type="text" wire:model="settings.hero_cta_text" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Link Tombol</label>
                                <input type="text" wire:model="settings.hero_cta_link" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">
                            </div>
                            <!-- Image Upload Placeholder -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Background (Opsional)</label>
                                <input type="file" wire:model="heroImage" class="w-full border border-gray-300 rounded-md p-2">
                                @if (isset($settings['hero_image']))
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500">Gambar saat ini:</p>
                                        <img src="{{ asset('storage/'.$settings['hero_image']) }}" class="h-20 w-auto rounded object-cover">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
                            <span class="mr-2">🕌</span> Tentang Pesantren
                        </h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Seksi</label>
                                <input type="text" wire:model="settings.about_title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                                <textarea wire:model="settings.about_text" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Footer & Contacts -->
                    <div class="pb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
                            <span class="mr-2">📍</span> Footer & Kontak
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teks Footer (Copyright/Motto)</label>
                                <input type="text" wire:model="settings.footer_text" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="text" wire:model="settings.contact_phone" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" wire:model="settings.contact_email" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <textarea wire:model="settings.contact_address" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"></textarea>
                            </div>
                            
                            <!-- Social Media -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sosial Media</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <input type="text" wire:model="settings.social_facebook" placeholder="Link Facebook" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <input type="text" wire:model="settings.social_instagram" placeholder="Link Instagram" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <input type="text" wire:model="settings.social_youtube" placeholder="Link Youtube" class="w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-md hover:bg-primary-700 transition shadow-lg flex items-center">
                            <span wire:loading.remove>Simpan Perubahan</span>
                            <span wire:loading class="animate-spin mr-2">⏳</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
