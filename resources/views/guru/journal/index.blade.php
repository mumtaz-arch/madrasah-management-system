<x-layouts.portal title="Jurnal Mengajar" role="guru">
    <div class="space-y-6">
        <!-- Header & Stats -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-heading">Jurnal Mengajar</h1>
                <p class="text-gray-500 text-sm">Catat dan kelola aktivitas pembelajaran Anda.</p>
            </div>
            <div>
                <a href="{{ route('guru.journal.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 w-full sm:w-auto justify-center">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Jurnal Baru
                </a>
            </div>
        </div>

        <!-- Dashboard Widget: Jurnal Hari Ini -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="p-4 sm:p-6 flex items-center gap-4">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Jurnal Hari Ini</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $todayJournalCount }}</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('guru.journal.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                    <input type="month" name="month" id="month" value="{{ request('month', date('Y-m')) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="class_id" id="class_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('class_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas & Mapel</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Materi</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Kehadiran</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative px-4 sm:px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($journals as $journal)
                            <tr>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $journal->date->format('d/m/Y') }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $journal->classroom->nama_kelas ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $journal->subject->nama ?? '-' }}</div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 hidden sm:table-cell">
                                    <div class="text-sm text-gray-900 line-clamp-1">{{ $journal->topic }}</div>
                                    <div class="text-xs text-gray-500 line-clamp-1">{{ $journal->method }}</div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                    <span class="text-green-600 font-medium">{{ $journal->present_count }} Hadir</span>
                                    <span class="mx-1">/</span>
                                    <span class="text-red-600 font-medium">{{ $journal->absent_count }} Absen</span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $journal->status_badge }}">
                                        {{ $journal->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($journal->status === 'draft')
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('guru.journal.edit', $journal) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('guru.journal.destroy', $journal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed">Locked</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada jurnal mengajar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-200">
                {{ $journals->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-layouts.portal>
