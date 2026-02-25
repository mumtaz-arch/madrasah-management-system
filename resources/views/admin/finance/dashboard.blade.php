<x-layouts.admin>
    <x-slot:title>Dashboard Keuangan</x-slot:title>
    <x-slot:header>Dashboard Keuangan</x-slot:header>
    
    @php
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Statistics
        $totalTagihan = \App\Models\Tagihan::sum('nominal');
        $totalPaid = \App\Models\Tagihan::where('status', 'paid')->sum('nominal');
        $totalPending = \App\Models\Tagihan::where('status', 'pending')->sum('nominal');
        $totalOverdue = \App\Models\Tagihan::where('status', 'overdue')->sum('nominal');
        
        // Monthly data for chart (last 6 months)
        $months = [];
        $pemasukanData = [];
        $tunggakanData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $pemasukanData[] = \App\Models\Tagihan::where('status', 'paid')
                ->whereMonth('tanggal_bayar', $date->month)
                ->whereYear('tanggal_bayar', $date->year)
                ->sum('nominal');
            
            $tunggakanData[] = \App\Models\Tagihan::whereIn('status', ['pending', 'overdue'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('nominal');
        }
        
        // Recent transactions
        $recentTransactions = \App\Models\Tagihan::with(['santri', 'paymentType'])
            ->where('status', 'paid')
            ->latest('tanggal_bayar')
            ->take(5)
            ->get();
        
        // Overdue reminders
        $overdueTagihans = \App\Models\Tagihan::with(['santri', 'paymentType'])
            ->where(function($q) {
                $q->where('status', 'overdue')
                  ->orWhere(function($sub) {
                      $sub->where('status', 'pending')
                          ->where('jatuh_tempo', '<', now());
                  });
            })
            ->take(5)
            ->get();
    @endphp
    
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Tagihan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Tagihan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Total Pemasukan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pemasukan</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Pending -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Belum Dibayar</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Overdue -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jatuh Tempo</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($totalOverdue, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart: Pemasukan vs Tunggakan -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Pemasukan vs Tunggakan (6 Bulan Terakhir)</h3>
                <canvas id="revenueChart" height="120"></canvas>
            </div>
            
            <!-- Pie Chart: Status Distribution -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Distribusi Status</h3>
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
        
        <!-- Bottom Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Transactions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Transaksi Terbaru</h3>
                    <a href="{{ route('admin.finance.tagihan') }}" class="text-sm text-primary-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentTransactions as $tx)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $tx->santri->nama_lengkap ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">{{ $tx->paymentType->nama ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">+Rp {{ number_format($tx->nominal, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400">{{ $tx->tanggal_bayar ? \Carbon\Carbon::parse($tx->tanggal_bayar)->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada transaksi</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Overdue Reminders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Reminder Jatuh Tempo
                    </h3>
                    <span class="px-2.5 py-1 text-xs font-bold bg-red-100 text-red-600 rounded-full">{{ $overdueTagihans->count() }} item</span>
                </div>
                <div class="space-y-3">
                    @forelse($overdueTagihans as $overdue)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                            <div>
                                <p class="font-medium text-gray-900">{{ $overdue->santri->nama_lengkap ?? '-' }}</p>
                                <p class="text-sm text-gray-500">{{ $overdue->paymentType->nama ?? '-' }} - {{ \Carbon\Carbon::parse($overdue->jatuh_tempo)->format('d M Y') }}</p>
                            </div>
                            <p class="font-semibold text-red-600">Rp {{ number_format($overdue->nominal, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <svg class="w-12 h-12 text-green-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500">Tidak ada tagihan jatuh tempo</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-xl p-6 text-white">
            <h3 class="font-semibold mb-4">Aksi Cepat</h3>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.finance.tagihan') }}" class="px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Kelola Tagihan
                </a>
                <a href="{{ route('admin.finance.reports') }}" class="px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan Keuangan
                </a>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Pemasukan',
                    data: {!! json_encode($pemasukanData) !!},
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Tunggakan',
                    data: {!! json_encode($tunggakanData) !!},
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
        
        // Status Pie Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Lunas', 'Pending', 'Jatuh Tempo'],
                datasets: [{
                    data: [{{ $totalPaid }}, {{ $totalPending }}, {{ $totalOverdue }}],
                    backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '60%'
            }
        });
    </script>
    @endpush
</x-layouts.admin>
