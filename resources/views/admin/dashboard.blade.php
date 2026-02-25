<x-layouts.admin>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:header>Dashboard Admin</x-slot:header>
    
    @php
        $totalSantri = \App\Models\Santri::count();
        $totalGuru = \App\Models\Guru::count();
        $totalKelas = \App\Models\Kelas::count();
        $totalPpdb = \App\Models\PpdbRegistration::where('status', 'pending')->count();
        
        $recentSantri = \App\Models\Santri::with('kelas')->latest()->take(5)->get();
        $recentPpdb = \App\Models\PpdbRegistration::latest()->take(5)->get();
        $announcements = \App\Models\Announcement::active()->latest()->take(3)->get();
        
        $totalJurnalBulanIni = \App\Models\TeacherJournal::whereMonth('date', now()->month)->whereYear('date', now()->year)->count();
    @endphp
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-6 mb-6 sm:mb-8">
        <!-- Total Santri -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">Total Santri</p>
                    <h3 class="text-xl sm:text-3xl font-bold text-gray-900">{{ number_format($totalSantri) }}</h3>
                    <p class="text-xs text-green-600 mt-1">
                        <span class="inline-flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            Aktif
                        </span>
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Guru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">Total Guru</p>
                    <h3 class="text-xl sm:text-3xl font-bold text-gray-900">{{ number_format($totalGuru) }}</h3>
                    <p class="text-xs text-blue-600 mt-1">Ustadz & Ustadzah</p>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Kelas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">Total Kelas</p>
                    <h3 class="text-xl sm:text-3xl font-bold text-gray-900">{{ number_format($totalKelas) }}</h3>
                    <p class="text-xs text-purple-600 mt-1">Tahun Ajaran 2024/2025</p>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">PPDB Pending</p>
                    <h3 class="text-xl sm:text-3xl font-bold text-gray-900">{{ number_format($totalPpdb) }}</h3>
                    <p class="text-xs text-orange-600 mt-1">Menunggu Verifikasi</p>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Jurnal Bulan Ini -->
         <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">Jurnal Bulan Ini</p>
                    <h3 class="text-xl sm:text-3xl font-bold text-gray-900">{{ number_format($totalJurnalBulanIni) }}</h3>
                    <p class="text-xs text-indigo-600 mt-1">Total Entri Guru</p>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    @php
        // Chart Data - Santri per Kelas
        $santriPerKelas = \App\Models\Kelas::withCount('santris')->get();
        $kelasLabels = $santriPerKelas->pluck('nama_kelas')->toArray();
        $santriCounts = $santriPerKelas->pluck('santris_count')->toArray();
        
        // Monthly registrations (last 6 months)
        $monthlyData = [];
        $monthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabels[] = $date->format('M Y');
            $monthlyData[] = \App\Models\Santri::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }
        
        // Payment Status
        $paidCount = \App\Models\Tagihan::where('status', 'paid')->count();
        $pendingCount = \App\Models\Tagihan::where('status', 'pending')->count();
        $overdueCount = \App\Models\Tagihan::where('status', 'overdue')->count();
        
        // Gender Distribution
        $maleCount = \App\Models\Santri::where('jenis_kelamin', 'L')->count();
        $femaleCount = \App\Models\Santri::where('jenis_kelamin', 'P')->count();
    @endphp
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <!-- Bar Chart: Santri per Kelas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Santri per Kelas</h3>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $totalSantri }} Total</span>
            </div>
            <canvas id="santriPerKelasChart" height="200"></canvas>
        </div>
        
        <!-- Line Chart: Trend Pendaftaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Trend Pendaftaran</h3>
                <span class="text-xs text-primary-600 bg-primary-50 px-2 py-1 rounded-full">6 Bulan Terakhir</span>
            </div>
            <canvas id="registrationTrendChart" height="200"></canvas>
        </div>
        
        <!-- Doughnut Chart: Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Status Pembayaran</h3>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $paidCount + $pendingCount + $overdueCount }} Total</span>
            </div>
            <canvas id="paymentStatusChart" height="200"></canvas>
        </div>
    </div>
    
    <!-- Second Row Charts -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <!-- Pie Chart: Gender -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Distribusi Gender</h3>
            </div>
            <canvas id="genderChart" height="180"></canvas>
            <div class="flex justify-center gap-6 mt-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Laki-laki ({{ $maleCount }})</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-pink-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Perempuan ({{ $femaleCount }})</span>
                </div>
            </div>
        </div>
        
        <!-- Horizontal Bar: Top Kelas -->
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Perbandingan Jumlah Santri</h3>
            </div>
            <canvas id="horizontalBarChart" height="150"></canvas>
        </div>
    </div>
    
    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Santri -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="font-heading font-semibold text-gray-900">Santri Terbaru</h3>
                    <a href="{{ route('admin.santri.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentSantri as $santri)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold text-sm">
                                        {{ substr($santri->nama_lengkap, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $santri->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $santri->nis }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $santri->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $santri->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($santri->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data santri
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Announcements -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="font-heading font-semibold text-gray-900">Pengumuman</h3>
                    <a href="{{ route('admin.announcements.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @forelse($announcements as $announcement)
                <div class="p-4 rounded-lg {{ $announcement->type === 'urgent' ? 'bg-red-50 border border-red-200' : ($announcement->type === 'warning' ? 'bg-yellow-50 border border-yellow-200' : 'bg-blue-50 border border-blue-200') }}">
                    <div class="flex items-start space-x-3">
                        @if($announcement->type === 'urgent')
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        @else
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        @endif
                        <div>
                            <h4 class="font-medium text-gray-900 text-sm">{{ $announcement->title }}</h4>
                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ Str::limit($announcement->content, 80) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <p>Belum ada pengumuman</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="mt-8 bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-6 text-white">
        <h3 class="font-heading font-semibold text-lg mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
            <a href="{{ route('admin.santri.index') }}" class="flex items-center space-x-3 bg-white/10 rounded-lg p-4 hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span class="font-medium">Tambah Santri</span>
            </a>
            <a href="{{ route('admin.guru.index') }}" class="flex items-center space-x-3 bg-white/10 rounded-lg p-4 hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span class="font-medium">Tambah Guru</span>
            </a>
            <a href="{{ route('admin.ppdb.index') }}" class="flex items-center space-x-3 bg-white/10 rounded-lg p-4 hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span class="font-medium">Verifikasi PPDB</span>
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="flex items-center space-x-3 bg-white/10 rounded-lg p-4 hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                <span class="font-medium">Buat Pengumuman</span>
            </a>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Color palette
        const colors = {
            primary: '#166534',
            primaryLight: 'rgba(22, 101, 52, 0.2)',
            blue: '#3B82F6',
            green: '#10B981',
            yellow: '#F59E0B',
            red: '#EF4444',
            pink: '#EC4899',
            purple: '#8B5CF6',
            cyan: '#06B6D4'
        };

        // 1. Bar Chart: Santri per Kelas
        const santriPerKelasCtx = document.getElementById('santriPerKelasChart').getContext('2d');
        const santriGradient = santriPerKelasCtx.createLinearGradient(0, 0, 0, 300);
        santriGradient.addColorStop(0, colors.primary);
        santriGradient.addColorStop(1, '#22c55e');
        
        new Chart(santriPerKelasCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($kelasLabels) !!},
                datasets: [{
                    label: 'Jumlah Santri',
                    data: {!! json_encode($santriCounts) !!},
                    backgroundColor: santriGradient,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            }
        });

        // 2. Line Chart: Registration Trend
        const trendCtx = document.getElementById('registrationTrendChart').getContext('2d');
        const trendGradient = trendCtx.createLinearGradient(0, 0, 0, 300);
        trendGradient.addColorStop(0, 'rgba(22, 101, 52, 0.4)');
        trendGradient.addColorStop(1, 'rgba(22, 101, 52, 0)');
        
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'Pendaftaran',
                    data: {!! json_encode($monthlyData) !!},
                    borderColor: colors.primary,
                    backgroundColor: trendGradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // 3. Doughnut Chart: Payment Status
        new Chart(document.getElementById('paymentStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Lunas', 'Pending', 'Jatuh Tempo'],
                datasets: [{
                    data: [{{ $paidCount }}, {{ $pendingCount }}, {{ $overdueCount }}],
                    backgroundColor: [colors.green, colors.yellow, colors.red],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: { padding: 15, usePointStyle: true, pointStyle: 'circle' }
                    }
                },
                animation: {
                    animateRotate: true,
                    duration: 1500
                }
            }
        });

        // 4. Pie Chart: Gender
        new Chart(document.getElementById('genderChart'), {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $maleCount }}, {{ $femaleCount }}],
                    backgroundColor: [colors.blue, colors.pink],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                animation: {
                    animateScale: true,
                    duration: 1200
                }
            }
        });

        // 5. Horizontal Bar Chart
        new Chart(document.getElementById('horizontalBarChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($kelasLabels) !!},
                datasets: [{
                    label: 'Jumlah Santri',
                    data: {!! json_encode($santriCounts) !!},
                    backgroundColor: [
                        colors.primary, colors.blue, colors.green, 
                        colors.purple, colors.cyan, colors.yellow,
                        colors.pink, colors.red
                    ],
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    y: { grid: { display: false } }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            }
        });
    </script>
    @endpush
</x-layouts.admin>
