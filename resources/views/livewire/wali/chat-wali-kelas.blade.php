<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="font-heading text-2xl font-bold text-gray-900">Chat dengan Wali Kelas</h1>
        <p class="text-gray-500">Komunikasi langsung dengan wali kelas anak Anda</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {{ session('error') }}
        </div>
    @endif

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
        @if($waliKelas)
        <!-- Chat Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Chat Header -->
            <div class="px-6 py-4 bg-primary-600 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold">
                        {{ strtoupper(substr($waliKelas->nama_lengkap ?? 'W', 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-semibold">{{ $waliKelas->nama_lengkap ?? 'Wali Kelas' }}</h3>
                        <p class="text-sm text-primary-200">Wali Kelas {{ $selectedSantri->kelas->nama_kelas ?? '' }}</p>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="h-96 overflow-y-auto p-4 space-y-4 bg-gray-50" id="chatMessages">
                @forelse($messages as $msg)
                    <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $msg->sender_id === auth()->id() ? 'bg-primary-600 text-white' : 'bg-white border border-gray-200 text-gray-900' }}">
                            <p class="text-sm">{{ $msg->message }}</p>
                            <p class="text-xs mt-1 {{ $msg->sender_id === auth()->id() ? 'text-primary-200' : 'text-gray-400' }}">
                                {{ $msg->created_at->format('d M, H:i') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p>Belum ada pesan. Mulai percakapan!</p>
                    </div>
                @endforelse
            </div>

            <!-- Input -->
            <div class="px-4 py-3 border-t border-gray-200 bg-white">
                <form wire:submit="sendMessage" class="flex gap-2">
                    <input type="text" wire:model="newMessage" 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="Tulis pesan...">
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Wali Kelas Belum Ditentukan</h3>
            <p class="text-gray-500">Kelas {{ $selectedSantri->kelas->nama_kelas ?? '' }} belum memiliki wali kelas.</p>
        </div>
        @endif
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

<script>
    document.addEventListener('livewire:navigated', () => {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
</script>
