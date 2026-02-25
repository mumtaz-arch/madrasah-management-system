<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Ujian CBT</h1>
            <p class="text-gray-500">Kelola ujian online</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Ujian
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Ujian</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mapel</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Durasi</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($exams as $exam)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $exam->nama }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $exam->mapel->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $exam->kelas->nama_kelas ?? '-' }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $exam->durasi }} menit</td>
                        <td class="px-6 py-4 text-center">{!! $exam->status_badge !!}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button wire:click="edit({{ $exam->id }})" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button wire:click="confirmDelete({{ $exam->id }})" class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada ujian</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($exams->hasPages())<div class="px-6 py-4 border-t">{{ $exams->links('vendor.pagination.tailwind') }}</div>@endif
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                    <form wire:submit="save">
                        <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold">{{ $editingId ? 'Edit' : 'Tambah' }} Ujian</h3></div>
                        <div class="p-6 space-y-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Ujian</label><input type="text" wire:model="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg">@error('nama')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror</div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label><select wire:model="mapel_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><option value="">Pilih</option>@foreach($mapels as $mapel)<option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>@endforeach</select>@error('mapel_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror</div>
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label><select wire:model="kelas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><option value="">Pilih</option>@foreach($kelasList as $kelas)<option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>@endforeach</select>@error('kelas_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label><input type="number" wire:model="durasi" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Status</label><select wire:model="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><option value="draft">Draft</option><option value="active">Aktif</option><option value="completed">Selesai</option></select></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Mulai</label><input type="datetime-local" wire:model="tanggal_mulai" class="w-full px-4 py-2 border border-gray-300 rounded-lg">@error('tanggal_mulai')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror</div>
                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Selesai</label><input type="datetime-local" wire:model="tanggal_selesai" class="w-full px-4 py-2 border border-gray-300 rounded-lg">@error('tanggal_selesai')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror</div>
                            </div>
                            <div class="flex space-x-6">
                                <label class="inline-flex items-center"><input type="checkbox" wire:model="acak_soal" class="w-4 h-4 text-primary-600 border-gray-300 rounded"><span class="ml-2 text-sm text-gray-700">Acak Soal</span></label>
                                <label class="inline-flex items-center"><input type="checkbox" wire:model="acak_jawaban" class="w-4 h-4 text-primary-600 border-gray-300 rounded"><span class="ml-2 text-sm text-gray-700">Acak Jawaban</span></label>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t bg-gray-50 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showDeleteModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6 text-center">
                    <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <h3 class="text-lg font-semibold mb-2">Hapus Ujian?</h3>
                    <p class="text-gray-500 mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                    <div class="flex justify-center space-x-3">
                        <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                        <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
