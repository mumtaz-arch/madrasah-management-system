<div>
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Analytics Dashboard</h1>
            <p class="text-gray-500">Analisis tren dan performa pesantren</p>
        </div>
        <div class="flex items-center gap-3">
            <select wire:model.live="period" class="px-4 py-2.5 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm font-medium shadow-sm">
                <option value="week">7 Hari Terakhir</option>
                <option value="month">30 Hari Terakhir</option>
                <option value="year">12 Bulan Terakhir</option>
            </select>
            <a href="{{ route('admin.analytics.export') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 font-medium text-sm shadow-sm transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export PDF
            </a>
        </div>
    </div>

    {{-- Summary Stats Grid - 5 cards matching website style --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
        {{-- Santri --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
                </div>
                @if($summaryStats['santri']['growth'] != 0)
                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $summaryStats['santri']['growth'] > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $summaryStats['santri']['growth'] > 0 ? '+' : '' }}{{ $summaryStats['santri']['growth'] }}%
                    </span>
                @endif
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($summaryStats['santri']['total']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Santri</p>
            <p class="text-xs text-gray-400 mt-2">{{ $summaryStats['santri']['active'] }} aktif</p>
        </div>

        {{-- Guru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($summaryStats['guru']['total']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Guru</p>
            <p class="text-xs text-gray-400 mt-2">{{ $summaryStats['guru']['active'] }} aktif</p>
        </div>

        {{-- Keuangan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @if($summaryStats['keuangan']['growth'] != 0)
                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $summaryStats['keuangan']['growth'] > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $summaryStats['keuangan']['growth'] > 0 ? '+' : '' }}{{ $summaryStats['keuangan']['growth'] }}%
                    </span>
                @endif
            </div>
            <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($summaryStats['keuangan']['thisMonth'] / 1000000, 1) }}M</p>
            <p class="text-sm text-gray-500 mt-1">Pemasukan Bulan Ini</p>
            <p class="text-xs text-red-500 mt-2">Tunggakan: Rp {{ number_format($summaryStats['keuangan']['tunggakan'] / 1000000, 1) }}M</p>
        </div>

        {{-- Akademik --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $summaryStats['akademik']['attendanceRate'] }}%</p>
            <p class="text-sm text-gray-500 mt-1">Tingkat Kehadiran</p>
            <p class="text-xs text-gray-400 mt-2">Rata-rata ujian: {{ $summaryStats['akademik']['examAverage'] }}</p>
        </div>

        {{-- PPDB --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($summaryStats['ppdb']['total']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Pendaftar PPDB</p>
            <p class="text-xs text-green-500 mt-2">{{ $summaryStats['ppdb']['accepted'] }} diterima ({{ $summaryStats['ppdb']['rate'] }}%)</p>
        </div>
    </div>

    {{-- Charts Section - 2 columns --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Payment Trend Chart --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-gray-900 text-lg">Tren Pembayaran</h3>
                <span class="text-sm text-gray-500">{{ $period === 'week' ? '7 hari' : ($period === 'month' ? '30 hari' : '12 bulan') }}</span>
            </div>
            <div class="h-64">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>

        {{-- Attendance Chart --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-gray-900 text-lg">Tren Kehadiran</h3>
                <span class="text-sm text-gray-500">{{ $period === 'week' ? '7 hari' : ($period === 'month' ? '30 hari' : '12 bulan') }}</span>
            </div>
            <div class="h-64">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Bottom Section - 3 columns --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Top Classes --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-900 text-lg mb-5">Kelas Terbesar</h3>
            <div class="space-y-4">
                @php
                    $topClasses = \App\Models\Kelas::withCount('santris')
                        ->orderByDesc('santris_count')
                        ->limit(5)
                        ->get();
                @endphp
                @forelse($topClasses as $index => $kelas)
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 flex items-center justify-center text-sm font-bold rounded-lg 
                            {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $index === 1 ? 'bg-gray-200 text-gray-700' : '' }}
                            {{ $index === 2 ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $index > 2 ? 'bg-gray-100 text-gray-500' : '' }}">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $kelas->nama_kelas }}</p>
                        </div>
                        <span class="text-sm font-semibold text-primary-600 bg-primary-50 px-3 py-1 rounded-lg">{{ $kelas->santris_count }} santri</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada data</p>
                @endforelse
            </div>
        </div>

        {{-- Recent PPDB --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-900 text-lg mb-5">Registrasi PPDB Terbaru</h3>
            <div class="space-y-4">
                @php $recentPpdb = \App\Models\PpdbRegistration::latest()->limit(5)->get(); @endphp
                @forelse($recentPpdb as $reg)
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($reg->nama_lengkap, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $reg->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500">{{ $reg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium flex-shrink-0
                            {{ $reg->status === 'diterima' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $reg->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $reg->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                            {{ !in_array($reg->status, ['diterima', 'pending', 'ditolak']) ? 'bg-gray-100 text-gray-600' : '' }}">
                            {{ ucfirst($reg->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada pendaftar</p>
                @endforelse
            </div>
        </div>

        {{-- Payment Status Distribution --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-900 text-lg mb-5">Status Pembayaran</h3>
            <div class="h-48">
                <canvas id="paymentStatusChart"></canvas>
            </div>
            @php 
                $statusData = \App\Models\Tagihan::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status'); 
            @endphp
            <div class="flex justify-center gap-4 mt-4 text-sm">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-500"></span> Lunas ({{ $statusData['lunas'] ?? 0 }})</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span> Belum ({{ $statusData['belum_bayar'] ?? 0 }})</div>
            </div>
        </div>
    </div>

    {{-- Chart.js Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initCharts();
        });
        
        document.addEventListener('livewire:navigated', function() {
            initCharts();
        });

        function initCharts() {
            const trendData = @json($trendData);
            const statusData = @json(\App\Models\Tagihan::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status'));
            
            // Destroy existing charts if they exist
            Chart.getChart('paymentChart')?.destroy();
            Chart.getChart('attendanceChart')?.destroy();
            Chart.getChart('paymentStatusChart')?.destroy();

            // Payment Chart
            const paymentCtx = document.getElementById('paymentChart');
            if (paymentCtx) {
                new Chart(paymentCtx, {
                    type: 'line',
                    data: {
                        labels: trendData.labels || [],
                        datasets: [{
                            label: 'Pembayaran',
                            data: trendData.payments || [],
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointBackgroundColor: 'rgb(16, 185, 129)',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)' },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + (value / 1000000).toFixed(0) + 'M';
                                    }
                                }
                            },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // Attendance Chart
            const attendanceCtx = document.getElementById('attendanceChart');
            if (attendanceCtx && trendData.attendance && trendData.attendance.length > 0) {
                new Chart(attendanceCtx, {
                    type: 'bar',
                    data: {
                        labels: trendData.labels || [],
                        datasets: [{
                            label: 'Kehadiran',
                            data: trendData.attendance || [],
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderRadius: 8,
                            borderSkipped: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // Payment Status Pie Chart
            const statusCtx = document.getElementById('paymentStatusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Lunas', 'Belum Bayar', 'Sebagian'],
                        datasets: [{
                            data: [statusData.lunas || 0, statusData.belum_bayar || 0, statusData.sebagian || 0],
                            backgroundColor: ['#22c55e', '#ef4444', '#f59e0b'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
        }
    </script>
</div>
