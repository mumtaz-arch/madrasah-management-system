<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Pengumuman & Berita</h1>
            <p class="text-gray-500">Kelola informasi, berita, dan pengumuman pesantren</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="btn-primary inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Berita
        </a>
    </div>

    @if(session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div class="relative w-full max-w-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Cari judul berita...">
            </div>
            <div wire:loading wire:target="search" class="text-sm text-gray-500 ml-3">
                Mencari...
            </div>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($announcements as $announcement)
                <div class="p-6 hover:bg-gray-50 flex flex-col md:flex-row gap-6">
                    @if($announcement->image)
                        <div class="w-full md:w-48 h-32 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden shrink-0">
                            <img src="{{ asset('storage/' . $announcement->image) }}" class="w-full h-full object-cover" alt="Thumbnail">
                        </div>
                    @else
                        <div class="w-full md:w-48 h-32 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0 text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    <div class="flex-1 flex flex-col justify-between min-w-0">
                        <div>
                            <div class="flex items-center space-x-2 mb-2">
                                <button wire:click="toggleActive({{ $announcement->id }})" class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-md border transition-colors {{ $announcement->is_active ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' : 'bg-gray-100 text-gray-600 border-gray-300 hover:bg-gray-200' }}">
                                    {{ $announcement->is_active ? '✅ Aktif Ditampilkan' : 'Draft / Sembunyi' }}
                                </button>
                                <span class="text-xs text-gray-500 font-medium bg-gray-100 px-2 py-1 rounded-md">{{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y, H:i') }}</span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-1 text-lg truncate">{{ $announcement->title }}</h3>
                            <p class="text-gray-600 text-sm line-clamp-2">{{ $announcement->excerpt ?? strip_tags($announcement->content) }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 md:pl-4 md:border-l border-gray-200 shrink-0">
                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg border border-transparent hover:border-primary-200 transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <button wire:click="delete({{ $announcement->id }})" wire:confirm="Yakin ingin menghapus berita ini?" class="p-2 text-red-600 hover:bg-red-50 rounded-lg border border-transparent hover:border-red-200 transition-colors" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <p class="text-gray-500 text-lg font-medium mb-1">Belum ada berita/pengumuman</p>
                    <p class="text-gray-400 text-sm mb-4">Mulai tambahkan informasi untuk ditampilkan di landing page.</p>
                    <a href="{{ route('admin.announcements.create') }}" class="btn-primary">Tambah Berita Pertama</a>
                </div>
            @endforelse
        </div>

        @if($announcements->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>
