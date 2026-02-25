<div class="min-h-screen bg-gray-100" x-data="{ 
    remainingSeconds: @entangle('remainingSeconds'),
    timerInterval: null,
    formatTime(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;
        return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }
}" x-init="
    timerInterval = setInterval(() => {
        if (remainingSeconds > 0) {
            remainingSeconds--;
        } else {
            clearInterval(timerInterval);
            $wire.submitExam();
        }
    }, 1000);
" x-on:beforeunload.window="clearInterval(timerInterval)">

    @if($isFinished)
        {{-- Results Screen --}}
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full text-center">
                <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="font-heading text-2xl font-bold text-gray-900 mb-2">Ujian Selesai!</h2>
                <p class="text-gray-500 mb-6">{{ $exam->title }}</p>
                
                <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 text-white mb-6">
                    <p class="text-sm opacity-90">Nilai Anda</p>
                    <p class="text-5xl font-bold">{{ number_format($attempt->nilai, 0) }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500">Soal Dijawab</p>
                        <p class="font-semibold text-gray-900">{{ $answeredCount }} / {{ $totalQuestions }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500">Waktu Selesai</p>
                        <p class="font-semibold text-gray-900">{{ $attempt->selesai->format('H:i') }}</p>
                    </div>
                </div>

                <a href="{{ route('santri.dashboard') }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    @else
        {{-- Exam Taking Screen --}}
        <div class="flex flex-col lg:flex-row min-h-screen" x-data="{ navOpen: false }">
            {{-- Mobile Timer Bar --}}
            <div class="lg:hidden sticky top-0 z-30 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $exam->title }}</h3>
                    <p class="text-xs text-gray-500">{{ $answeredCount }}/{{ $totalQuestions }} dijawab</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="px-3 py-1.5 rounded-lg text-sm font-bold font-mono" :class="remainingSeconds < 300 ? 'bg-red-100 text-red-700' : 'bg-primary-100 text-primary-700'" x-text="formatTime(remainingSeconds)"></div>
                    <button @click="navOpen = !navOpen" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Question Navigator (Slide Down) --}}
            <div x-show="navOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden bg-white border-b border-gray-200 px-4 py-4" x-cloak>
                <p class="text-sm font-medium text-gray-700 mb-3">Navigasi Soal</p>
                <div class="grid grid-cols-8 sm:grid-cols-10 gap-2 mb-4">
                    @foreach($questions as $index => $q)
                        <button wire:click="goToQuestion({{ $index }})" @click="navOpen = false"
                                class="w-9 h-9 rounded-lg text-xs font-medium transition-all
                                {{ $index === $currentIndex ? 'ring-2 ring-primary-500 ring-offset-1' : '' }}
                                {{ isset($answers[$q['id']]) && $answers[$q['id']] !== '' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
                <button wire:click="submitExam" wire:confirm="Anda yakin ingin mengumpulkan ujian? Ini tidak dapat dibatalkan."
                        class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-colors text-sm">
                    Kumpulkan Ujian
                </button>
            </div>

            {{-- Desktop Sidebar - Question Navigator --}}
            <div class="hidden lg:block lg:w-72 bg-white border-r border-gray-200 p-4 lg:fixed lg:top-0 lg:left-0 lg:h-screen lg:overflow-y-auto">
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-900">{{ $exam->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $exam->mapel->nama ?? '-' }}</p>
                </div>

                {{-- Timer --}}
                <div class="mb-6 p-4 rounded-xl" :class="remainingSeconds < 300 ? 'bg-red-100' : 'bg-primary-100'">
                    <p class="text-xs font-medium mb-1" :class="remainingSeconds < 300 ? 'text-red-600' : 'text-primary-600'">Sisa Waktu</p>
                    <p class="text-2xl font-bold font-mono" :class="remainingSeconds < 300 ? 'text-red-700' : 'text-primary-700'" x-text="formatTime(remainingSeconds)"></p>
                </div>

                {{-- Progress --}}
                <div class="mb-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress</span>
                        <span class="font-medium text-gray-900">{{ $answeredCount }}/{{ $totalQuestions }}</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-primary-600 rounded-full transition-all" style="width: {{ $totalQuestions > 0 ? ($answeredCount / $totalQuestions) * 100 : 0 }}%"></div>
                    </div>
                </div>

                {{-- Question Navigator --}}
                <p class="text-sm font-medium text-gray-700 mb-3">Navigasi Soal</p>
                <div class="grid grid-cols-5 gap-2">
                    @foreach($questions as $index => $q)
                        <button wire:click="goToQuestion({{ $index }})" 
                                class="w-10 h-10 rounded-lg text-sm font-medium transition-all
                                {{ $index === $currentIndex ? 'ring-2 ring-primary-500 ring-offset-2' : '' }}
                                {{ isset($answers[$q['id']]) && $answers[$q['id']] !== '' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>

                {{-- Submit Button --}}
                <div class="mt-6">
                    <button wire:click="submitExam" wire:confirm="Anda yakin ingin mengumpulkan ujian? Ini tidak dapat dibatalkan." 
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-colors">
                        Kumpulkan Ujian
                    </button>
                </div>
            </div>

            {{-- Main Content - Question --}}
            <div class="flex-1 lg:ml-72 p-4 sm:p-6 lg:p-8">
                @if($currentQuestion)
                    <div class="max-w-3xl mx-auto">
                        {{-- Question Card --}}
                        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            {{-- Question Header --}}
                            <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Soal {{ $currentIndex + 1 }} dari {{ $totalQuestions }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $currentQuestion['jenis'] === 'pilihan_ganda' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $currentQuestion['jenis'] === 'pilihan_ganda' ? 'Pilihan Ganda' : 'Essay' }}
                                </span>
                            </div>

                            {{-- Question Content --}}
                            <div class="p-4 sm:p-6">
                                <div class="prose prose-sm sm:prose-lg max-w-none mb-6">
                                    {!! nl2br(e($currentQuestion['pertanyaan'])) !!}
                                </div>

                                {{-- Answer Options --}}
                                @if($currentQuestion['jenis'] === 'pilihan_ganda' && !empty($currentQuestion['pilihan']))
                                    <div class="space-y-3">
                                        @foreach($currentQuestion['pilihan'] as $key => $option)
                                            <label class="flex items-start p-3 sm:p-4 rounded-xl border-2 cursor-pointer transition-all
                                                {{ ($answers[$currentQuestion['id']] ?? '') === $key ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}">
                                                <input type="radio" 
                                                       name="answer_{{ $currentQuestion['id'] }}" 
                                                       value="{{ $key }}"
                                                       wire:click="saveAnswer({{ $currentQuestion['id'] }}, '{{ $key }}')"
                                                       {{ ($answers[$currentQuestion['id']] ?? '') === $key ? 'checked' : '' }}
                                                       class="mt-1 w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                                <span class="ml-3">
                                                    <span class="font-semibold text-gray-700">{{ $key }}.</span>
                                                    <span class="text-gray-600">{{ $option }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    {{-- Essay Answer --}}
                                    <textarea wire:model.blur="answers.{{ $currentQuestion['id'] }}" 
                                              wire:change="saveAnswer({{ $currentQuestion['id'] }}, $event.target.value)"
                                              rows="6"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none"
                                              placeholder="Tulis jawaban Anda di sini..."></textarea>
                                @endif
                            </div>

                            {{-- Navigation --}}
                            <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                                <button wire:click="prevQuestion" 
                                        {{ $currentIndex === 0 ? 'disabled' : '' }}
                                        class="px-4 sm:px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-colors text-sm sm:text-base">
                                    ← <span class="hidden sm:inline">Sebelumnya</span><span class="sm:hidden">Prev</span>
                                </button>
                                <button wire:click="nextQuestion"
                                        {{ $currentIndex === count($questions) - 1 ? 'disabled' : '' }}
                                        class="px-4 sm:px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-colors text-sm sm:text-base">
                                    <span class="hidden sm:inline">Selanjutnya</span><span class="sm:hidden">Next</span> →
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">Tidak ada soal untuk ditampilkan</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
