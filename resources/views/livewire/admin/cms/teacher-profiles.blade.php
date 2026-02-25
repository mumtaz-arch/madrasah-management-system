<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Profil Guru di Landing</h1>
            <p class="text-gray-500">Kelola guru yang ditampilkan di halaman depan</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="px-4 py-2 bg-primary-100 text-primary-700 rounded-lg font-medium">
                {{ $landingCount }} Guru Ditampilkan
            </span>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">{{ session('success') }}</div>
    @endif

    {{-- Search --}}
    <div class="mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama guru atau bidang keahlian..." class="w-full md:w-96 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Foto</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Guru</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Bidang Keahlian</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jabatan</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Tampil di Landing</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($teachers as $teacher)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($teacher->foto)
                                <img src="{{ Storage::url($teacher->foto) }}" alt="{{ $teacher->nama_lengkap }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                                    <span class="text-primary-600 font-semibold">{{ substr($teacher->nama_lengkap, 0, 2) }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $teacher->nama_lengkap }}</div>
                            <div class="text-sm text-gray-500">{{ $teacher->nip ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $teacher->bidang_keahlian ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $teacher->jabatan ?? 'Guru' }}</td>
                        <td class="px-6 py-4 text-center">
                            <button wire:click="toggleLandingVisibility({{ $teacher->id }})" 
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 {{ $teacher->show_on_landing ? 'bg-primary-600' : 'bg-gray-200' }}">
                                <span class="sr-only">Toggle landing visibility</span>
                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $teacher->show_on_landing ? 'translate-x-5' : 'translate-x-0' }}"></span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada guru</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($teachers->hasPages())<div class="px-6 py-4 border-t">{{ $teachers->links('vendor.pagination.tailwind') }}</div>@endif
    </div>

    {{-- Info Card --}}
    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-800">Catatan</h4>
                <p class="text-sm text-blue-700">Guru yang ditandai aktif akan muncul di bagian "Tim Pengajar" pada halaman depan website. Pastikan foto guru sudah diupload untuk tampilan yang lebih baik.</p>
            </div>
        </div>
    </div>
</div>
