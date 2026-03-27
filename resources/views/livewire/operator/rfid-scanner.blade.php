<div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center p-4 relative overflow-hidden"
     x-data="{ 
         currentTime: '',
         currentDate: '',
         init() {
             this.updateTime();
             setInterval(() => this.updateTime(), 1000);
             
             // Keep focus on the hidden input
             this.$nextTick(() => {
                 this.$refs.rfidInput.focus();
             });
         },
         updateTime() {
             const now = new Date();
             this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
             this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
         },
         refocus() {
             setTimeout(() => { this.$refs.rfidInput.focus(); }, 100);
         }
     }"
     @click="refocus"
>
    <!-- Hidden input for RFID Scanner -->
    <form wire:submit="processScan" class="opacity-0 absolute top-0 left-0 w-0 h-0 overflow-hidden">
        <input type="text" 
               wire:model="rfid_uid" 
               x-ref="rfidInput" 
               @blur="refocus"
               autofocus 
               autocomplete="off" 
               class="opacity-0">
    </form>

    <!-- Top Action Bar -->
    <div class="absolute top-6 left-6 z-30">
        @php
            $backRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('guru.dashboard');
            // Assuming "operator" role goes to admin dashboard for now, adjust if they have their own
            if(auth()->user()->role === 'operator') $backRoute = route('admin.dashboard'); 
        @endphp
        <a href="{{ $backRoute }}" class="inline-flex items-center justify-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl backdrop-blur-md transition-all duration-300 font-medium group border border-white/10 shadow-lg" title="Kembali ke Dashboard">
            <svg class="w-5 h-5 mr-0 sm:mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <!-- Header / Status -->
    <div class="absolute top-10 left-0 right-0 text-center z-10 animate-[fadeInDown_1s_ease-out]">
        <h1 class="text-4xl md:text-5xl font-bold tracking-wider font-heading drop-shadow-lg text-transparent bg-clip-text bg-gradient-to-r from-white to-primary-200">
            SISTEM ABSENSI MADRASAH
        </h1>
        <p class="text-primary-100/70 mt-3 text-lg font-medium">Silakan tempelkan kartu RFID Anda pada reader</p>
    </div>

    <!-- Clock -->
    <div class="absolute top-24 right-10 text-right hidden lg:block z-10 animate-[fadeInDown_1s_ease-out]">
        <div class="text-3xl font-bold text-white font-mono drop-shadow-lg" x-text="currentTime"></div>
        <div class="text-gray-400" x-text="currentDate"></div>
    </div>

    <!-- Mode Selector (For Operator) -->
    <div class="absolute top-6 right-6 sm:right-10 z-30 animate-[fadeInDown_1s_ease-out]">
        <div class="bg-gray-800/80 backdrop-blur-md rounded-xl border border-gray-700 p-2 shadow-lg flex items-center gap-3">
            <span class="text-sm text-gray-400 font-medium pl-2 hidden sm:block">Mode Presensi:</span>
            <select wire:model.live="kegiatan_id" class="bg-gray-900 text-white text-sm font-bold border-gray-600 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 cursor-pointer">
                <option value="">⭐ Akademik Harian</option>
                @foreach($kegiatans as $kegiatan)
                    <option value="{{ $kegiatan->id }}">🎯 {{ $kegiatan->nama_kegiatan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="w-full max-w-4xl relative z-20 mt-20">
        
        @if(!$lastScanResult)
            <!-- Idle State -->
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-16 text-center shadow-2xl relative overflow-hidden group shadow-primary-900/20">
                <!-- Decorative animated rings -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-64 h-64 border border-primary-500/20 rounded-full animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite]"></div>
                    <div class="absolute w-48 h-48 border border-primary-400/30 rounded-full animate-[ping_2s_cubic-bezier(0,0,0.2,1)_infinite_0.5s]"></div>
                </div>

                <div class="relative z-10">
                    <div class="w-40 h-40 mx-auto bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center shadow-lg shadow-primary-500/50 mb-8 border-4 border-white/30">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2">MENUNGGU KARTU...</h2>
                    <p class="text-gray-300">Tap kartu ke reader RFID untuk melakukan absensi otomatis</p>
                </div>
            </div>
        @else
            <!-- Result State -->
            @php
                $bgClass = 'bg-gray-800 border-gray-700';
                $iconColor = 'text-gray-400';
                $iconPath = '';
                
                if ($lastScanResult['type'] === 'success') {
                    $bgClass = 'bg-green-900/40 border-green-500/50 shadow-green-900/50';
                    $iconColor = 'text-green-400';
                    $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />';
                } elseif ($lastScanResult['type'] === 'warning') {
                    $bgClass = 'bg-yellow-900/40 border-yellow-500/50 shadow-yellow-900/50';
                    $iconColor = 'text-yellow-400';
                    $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />';
                } else {
                    $bgClass = 'bg-red-900/40 border-red-500/50 shadow-red-900/50';
                    $iconColor = 'text-red-400';
                    $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />';
                }
            @endphp

            <div class="{{ $bgClass }} backdrop-blur-xl border-2 rounded-3xl p-8 relative shadow-2xl overflow-hidden transition-all duration-500 transform scale-100"
                 x-data="{ show: true }"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300 transform"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @scan-success.window="show = true; setTimeout(() => show = false, 5000)"
                 @scan-warning.window="show = true; setTimeout(() => show = false, 5000)"
                 @scan-error.window="show = true; setTimeout(() => show = false, 5000)"
            >
                <div class="flex flex-col md:flex-row items-center gap-8">
                    
                    @if(isset($lastScanResult['santri']))
                        <!-- Profile Image -->
                        <div class="shrink-0 relative">
                            @if($lastScanResult['santri']['foto'])
                                <img src="{{ Storage::url($lastScanResult['santri']['foto']) }}" alt="Foto" class="w-48 h-48 rounded-2xl object-cover border-4 border-white/20 shadow-xl">
                            @else
                                <div class="w-48 h-48 rounded-2xl bg-gray-700/50 border-4 border-white/20 shadow-xl flex items-center justify-center">
                                    <svg class="w-24 h-24 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Status Badge Overlapping -->
                            <div class="absolute -bottom-4 -right-4 w-16 h-16 rounded-full bg-gray-900 flex items-center justify-center border-4 border-gray-800 shadow-lg {{ $lastScanResult['type'] === 'success' ? 'text-green-500' : 'text-yellow-500' }}">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $iconPath !!}
                                </svg>
                            </div>
                        </div>

                        <!-- Data & Message -->
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-4xl font-bold text-white mb-2 font-heading">{{ $lastScanResult['santri']['nama_lengkap'] }}</h3>
                            <div class="flex flex-wrap gap-3 justify-center md:justify-start mb-6">
                                <span class="px-4 py-1.5 rounded-full bg-white/10 text-white font-medium backdrop-blur-sm border border-white/10">NIS: {{ $lastScanResult['santri']['nis'] }}</span>
                                <span class="px-4 py-1.5 rounded-full bg-white/10 text-white font-medium backdrop-blur-sm border border-white/10">Kelas: {{ $lastScanResult['santri']['kelas'] }}</span>
                            </div>

                            <div class="mt-8 p-4 rounded-xl {{ $lastScanResult['type'] === 'success' ? 'bg-green-500/20 border border-green-500/30' : 'bg-yellow-500/20 border border-yellow-500/30' }}">
                                <p class="text-2xl font-bold {{ $iconColor }}">
                                    {{ $lastScanResult['message'] }}
                                </p>
                                @if(isset($lastScanResult['time']))
                                    <p class="text-white mt-1 text-lg">Pukul {{ $lastScanResult['time'] }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Error without Santri Data -->
                        <div class="w-full text-center py-12">
                            <svg class="w-32 h-32 mx-auto {{ $iconColor }} mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $iconPath !!}
                            </svg>
                            <h3 class="text-4xl font-bold text-white mb-4">{{ $lastScanResult['message'] }}</h3>
                            <p class="text-xl text-red-200">Silakan hubungi admin jika kartu Anda belum terdaftar.</p>
                        </div>
                    @endif

                </div>
            </div>
            
            <!-- Hidden Audio Elements -->
            @if($lastScanResult['type'] === 'success')
                <!-- Beep sound for success -->
                <audio autoplay class="hidden">
                    <source src="data:audio/mp3;base64,//OExAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq" type="audio/mpeg">
                </audio>
            @elseif($lastScanResult['type'] === 'error')
                <!-- Error sound -->
                <audio autoplay class="hidden">
                     <source src="data:audio/mp3;base64,//OExAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq" type="audio/mpeg">
                </audio>
            @endif
        @endif
    </div>

    <!-- Decorative Elements -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary-600/10 blur-[120px] pointer-events-none z-0"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-blue-600/10 blur-[120px] pointer-events-none z-0"></div>
</div>
