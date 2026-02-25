<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Bank Soal</h1>
            <p class="text-gray-500">Kelola soal untuk ujian CBT</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.cbt.questions.template') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Template
            </a>
            <a href="{{ route('admin.cbt.questions.export', ['mapel_id' => $filterMapel]) }}" class="inline-flex items-center px-3 py-2 border border-green-500 text-green-600 rounded-lg hover:bg-green-50 text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export
            </a>
            <button type="button" onclick="document.getElementById('import-modal').classList.remove('hidden')" class="inline-flex items-center px-3 py-2 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import
            </button>
            <button wire:click="openModal" class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Soal
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari soal..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <select wire:model.live="filterMapel" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Mapel</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterJenis" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Jenis</option>
                    <option value="pilihan_ganda">Pilihan Ganda</option>
                    <option value="essay">Essay</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Questions Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pertanyaan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mapel</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jenis</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Poin</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($questions as $q)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <p class="text-gray-900 line-clamp-2">{{ Str::limit($q->pertanyaan, 80) }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $q->mapel->nama ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $q->jenis === 'pilihan_ganda' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $q->jenis === 'pilihan_ganda' ? 'PG' : 'Essay' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-medium">{{ $q->poin }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="edit({{ $q->id }})" class="btn-action-edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $q->id }})" class="btn-action-delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                Belum ada soal. Tambahkan soal baru untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($questions->hasPages())
            <div class="px-6 py-4 border-t">{{ $questions->links('vendor.pagination.tailwind') }}</div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <form wire:submit="save">
                        <div class="px-6 py-4 border-b">
                            <h3 class="text-lg font-semibold">{{ $editingId ? 'Edit Soal' : 'Tambah Soal Baru' }}</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                                    <select wire:model="mapel_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Pilih Mapel</option>
                                        @foreach($mapels as $m)
                                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('mapel_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Soal</label>
                                    <select wire:model.live="jenis" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="pilihan_ganda">Pilihan Ganda</option>
                                        <option value="essay">Essay</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                                <textarea wire:model="pertanyaan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                                @error('pertanyaan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            @if($jenis === 'pilihan_ganda')
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Pilihan Jawaban</label>
                                    @foreach(['A', 'B', 'C', 'D'] as $i => $opt)
                                        <div class="flex items-center space-x-2">
                                            <input type="radio" wire:model="jawaban_benar" value="{{ $opt }}" class="w-4 h-4 text-primary-600">
                                            <span class="font-medium w-6">{{ $opt }}.</span>
                                            <input type="text" wire:model="pilihan.{{ $i }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg" placeholder="Pilihan {{ $opt }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Poin</label>
                                <input type="number" wire:model="poin" min="1" class="w-24 px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t bg-gray-50 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</button>
                            <button type="submit" class="btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showDeleteModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
                    <div class="p-6 text-center">
                        <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Soal?</h3>
                        <p class="text-gray-500 mb-6">Soal yang dihapus tidak dapat dikembalikan.</p>
                        <div class="flex justify-center space-x-3">
                            <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg">Batal</button>
                            <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Import Modal -->
    <div id="import-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" onclick="document.getElementById('import-modal').classList.add('hidden')"></div>
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
                <form action="{{ route('admin.cbt.questions.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold">Import Soal dari Excel</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                            <select name="mapel_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Pilih Mapel</option>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">File Excel</label>
                            <input type="file" name="file" accept=".xlsx,.xls" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">Format: .xlsx atau .xls</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t bg-gray-50 flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
