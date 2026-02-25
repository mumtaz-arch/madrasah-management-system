<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="font-heading text-2xl font-bold text-gray-900">Tagihan Anak</h1>
        <p class="text-gray-500">Lihat status tagihan dan riwayat pembayaran</p>
    </div>

    <!-- Santri Selector -->
    @if($santris->count() > 1)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Anak</label>
        <div class="flex flex-wrap gap-2">
            @foreach($santris as $santri)
                <button wire:click="$set('selectedSantriId', {{ $santri->id }})"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                    {{ $selectedSantriId == $santri->id ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $santri->nama_lengkap }}
                </button>
            @endforeach
        </div>
    </div>
    @endif

    @if($selectedSantri)
    <!-- Info Anak -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xl">
                {{ strtoupper(substr($selectedSantri->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $selectedSantri->nama_lengkap }}</h3>
                <p class="text-sm text-gray-500">{{ $selectedSantri->kelas->nama_kelas ?? '-' }} • NIS: {{ $selectedSantri->nis }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Total Tagihan</p>
            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($stats['total_tagihan'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <p class="text-xs text-green-600 uppercase tracking-wider">Lunas</p>
            <p class="text-xl font-bold text-green-700">Rp {{ number_format($stats['total_lunas'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <p class="text-xs text-yellow-600 uppercase tracking-wider">Pending</p>
            <p class="text-xl font-bold text-yellow-700">Rp {{ number_format($stats['total_pending'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <p class="text-xs text-red-600 uppercase tracking-wider">Terlambat</p>
            <p class="text-xl font-bold text-red-700">Rp {{ number_format($stats['total_overdue'], 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <button wire:click="$set('filterStatus', '')" 
                class="px-4 py-2 rounded-lg text-sm font-medium {{ !$filterStatus ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Semua
            </button>
            <button wire:click="$set('filterStatus', 'pending')" 
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $filterStatus === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Pending
            </button>
            <button wire:click="$set('filterStatus', 'paid')" 
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $filterStatus === 'paid' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Lunas
            </button>
            <button wire:click="$set('filterStatus', 'overdue')" 
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $filterStatus === 'overdue' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Terlambat
            </button>
        </div>
    </div>

    <!-- Tagihan List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Daftar Tagihan</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($tagihans as $tagihan)
            <div class="p-4 hover:bg-gray-50">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-semibold text-gray-900">{{ $tagihan->paymentType->nama ?? 'Tagihan' }}</h4>
                            <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full
                                {{ $tagihan->status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $tagihan->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $tagihan->status === 'overdue' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $tagihan->status === 'paid' ? 'Lunas' : ($tagihan->status === 'pending' ? 'Pending' : 'Terlambat') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">Jatuh tempo: {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</p>
                        @if($tagihan->keterangan)
                            <p class="text-sm text-gray-500 mt-1">{{ $tagihan->keterangan }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</p>
                        @if($tagihan->status === 'paid' && $tagihan->tanggal_bayar)
                            <p class="text-xs text-green-600">Dibayar {{ \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d M Y') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Tidak ada tagihan
            </div>
            @endforelse
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak Ada Data Anak</h3>
        <p class="text-gray-500">Anda belum memiliki data anak yang terdaftar.</p>
    </div>
    @endif
</div>
