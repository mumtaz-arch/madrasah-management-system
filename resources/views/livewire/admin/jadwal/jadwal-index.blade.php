<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Jadwal Mengajar</h1>
            <p class="text-gray-500">Kelola jadwal pelajaran pesantren (Senin - Sabtu)</p>
        </div>
        <div class="flex items-center gap-2">
             <button wire:click="create" 
                class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Jadwal
            </button>

            <!-- Import/Export Dropdown -->
            <div x-data="{ openDropdown: false }" class="relative">
                <button @click="openDropdown = !openDropdown" @click.away="openDropdown = false" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-sm transition-all text-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Import/Export
                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="openDropdown" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 py-1"
                     style="display: none;">
                    
                    <a href="{{ route('admin.jadwal.template') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download Template
                    </a>

                    <button @click="openDropdown = false; $dispatch('open-import-modal')" class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-left">
                        <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Import Data
                    </button>

                    <a href="{{ route('admin.jadwal.export') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export Semua Data
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.jadwal.export-pdf') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>

            <!-- Import Modal (Components) -->
            <div x-data="{ open: false }" @open-import-modal.window="open = true">
                 <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="open = false">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form action="{{ route('admin.jadwal.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Import Jadwal</h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500 mb-4">
                                                    Upload file Excel (.xlsx) sesuai template.
                                                </p>
                                                <input type="file" name="file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                        Import
                                    </button>
                                    <button @click="open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center">
             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col md:flex-row gap-4">
        <div class="relative flex-1 md:flex-none md:w-64">
            <input wire:model.live="search" type="text" placeholder="Cari jadwal..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-900 focus:ring-primary-500 focus:border-primary-500 shadow-sm">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>
        <select wire:model.live="filterKelas" class="flex-1 md:flex-none md:w-48 bg-white border border-gray-300 rounded-lg text-gray-900 focus:ring-primary-500 focus:border-primary-500 shadow-sm">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterGuru" class="flex-1 md:flex-none md:w-48 bg-white border border-gray-300 rounded-lg text-gray-900 focus:ring-primary-500 focus:border-primary-500 shadow-sm">
            <option value="">Semua Guru</option>
            @foreach($guruList as $guru)
                <option value="{{ $guru->id }}">{{ $guru->nama_lengkap }}</option>
            @endforeach
        </select>
    </div>

    <!-- Calendar Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        @foreach($groupedJadwals as $hari => $kelasGroups)
            <div x-data="{ expandedDay: false }" class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full transition-all duration-200" :class="{ 'h-auto': expandedDay, 'h-14': !expandedDay }">
                <!-- Day Header -->
                <button @click="expandedDay = !expandedDay" class="w-full px-4 py-3 border-b border-gray-200 flex items-center justify-between bg-gray-50 rounded-t-xl hover:bg-gray-100 transition-colors">
                    <h3 class="font-bold text-gray-700 uppercase">{{ $hari }}</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-gray-500 bg-white px-2 py-1 rounded-full border border-gray-200">
                             {{ $kelasGroups->flatten()->count() }} Mapel
                        </span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" :class="{ 'rotate-180': expandedDay }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>

                <!-- Schedule List -->
                <div x-show="expandedDay" x-collapse class="p-3 flex-1 space-y-3 min-h-[50px]">
                    @forelse($kelasGroups as $namaKelas => $jadwals)
                         <!-- Class Group -->
                         <div x-data="{ expandedClass: false }" class="border border-gray-100 rounded-lg overflow-hidden">
                            <!-- Class Header -->
                             @php
                                // Color palette for class headers (Soft/Pastel)
                                $headerColors = [
                                    'bg-blue-100 text-blue-800', 
                                    'bg-green-100 text-green-800', 
                                    'bg-yellow-100 text-yellow-800', 
                                    'bg-purple-100 text-purple-800', 
                                    'bg-pink-100 text-pink-800', 
                                    'bg-indigo-100 text-indigo-800', 
                                    'bg-red-100 text-red-800', 
                                    'bg-orange-100 text-orange-800',
                                    'bg-teal-100 text-teal-800',
                                    'bg-cyan-100 text-cyan-800'
                                ];
                                // Use a hash of the class name to ensure consistent color for the same class
                                $colorIndex = crc32($namaKelas) % count($headerColors);
                                $headerClass = $headerColors[$colorIndex];
                            @endphp
                            <button @click="expandedClass = !expandedClass" class="w-full px-3 py-2 flex items-center justify-between {{ $headerClass }} hover:opacity-80 transition-opacity">
                                <span class="font-semibold text-sm text-gray-700">{{ $namaKelas }}</span>
                                <div class="flex items-center gap-1">
                                    <span class="text-[10px] text-gray-500 bg-white/50 px-1.5 py-0.5 rounded">{{ $jadwals->count() }}</span>
                                    <svg class="w-4 h-4 text-gray-500 transform transition-transform duration-200" :class="{ 'rotate-180': expandedClass }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>

                            <!-- Class Schedules -->
                            <div x-show="expandedClass" x-collapse class="p-2 space-y-2 bg-white">
                                @foreach($jadwals as $jadwal)
                                    @php
                                        // Use the passed colors map, fallback to white/light gray
                                        $cardColor = $mapelColors[$jadwal->mapel_id] ?? '#ffffff';
                                    @endphp
                                    <div wire:click="edit({{ $jadwal->id }})" 
                                         style="background-color: {{ $cardColor }};"
                                         class="group relative border border-gray-200 rounded-md p-2 hover:border-gray-400 hover:shadow-sm transition-all cursor-pointer">
                                        
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-bold text-gray-800 text-xs line-clamp-1 break-all">{{ $jadwal->mapel->nama }}</h4>
                                                <div class="flex items-center gap-1 mt-1">
                                                    <span class="text-[10px] font-medium text-gray-700 bg-white/50 px-1.5 py-0.5 rounded">
                                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Delete (Hover) -->
                                            <button wire:click.stop="confirmDelete({{ $jadwal->id }})" class="p-1 text-gray-500 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>

                                         <div class="mt-2 flex items-center gap-1.5 border-t border-black/5 pt-1.5">
                                            <div class="w-4 h-4 rounded-full bg-white/50 flex items-center justify-center text-[8px] text-gray-700 font-bold border border-black/5">
                                                {{ substr($jadwal->guru->nama_lengkap, 0, 1) }}
                                            </div>
                                            <span class="text-[10px] text-gray-700 truncate max-w-[100px]">{{ $jadwal->guru->nama_lengkap }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-400 text-xs">
                            Tidak ada jadwal
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    <!-- Edit/Create Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('showEditModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                                {{ $isEdit ? 'Edit Jadwal' : 'Tambah Jadwal Baru' }}
                            </h3>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Guru -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Guru</label>
                                    <select wire:model="form.guru_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        <option value="">Pilih Guru</option>
                                        @foreach($guruList as $guru)
                                            <option value="{{ $guru->id }}">{{ $guru->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.guru_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Kelas & Mapel -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                                        <select wire:model="form.kelas_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                            <option value="">Pilih Kelas</option>
                                            @foreach($kelasList as $kelas)
                                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.kelas_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                        <select wire:model="form.mapel_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                            <option value="">Pilih Mapel</option>
                                            @foreach($mapelList as $mapel)
                                                <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.mapel_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Hari & Waktu -->
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hari</label>
                                        <select wire:model="form.hari" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                            <option value="senin">Senin</option>
                                            <option value="selasa">Selasa</option>
                                            <option value="rabu">Rabu</option>
                                            <option value="kamis">Kamis</option>
                                            <option value="jumat">Jumat</option>
                                            <option value="sabtu">Sabtu</option>
                                        </select>
                                        @error('form.hari') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                                        <input type="time" wire:model="form.jam_mulai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        @error('form.jam_mulai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                                        <input type="time" wire:model="form.jam_selesai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        @error('form.jam_selesai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <!-- Tahun Ajaran -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                                    <input type="text" wire:model="form.tahun_ajaran" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    @error('form.tahun_ajaran') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan
                            </button>
                            <button type="button" wire:click="$set('showEditModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showDeleteModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Jadwal</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus jadwal ini?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteJadwal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Hapus
                        </button>
                        <button wire:click="$set('showDeleteModal', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
