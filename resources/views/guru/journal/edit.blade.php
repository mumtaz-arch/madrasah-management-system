<x-layouts.portal title="Edit Jurnal" role="guru">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('guru.journal.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900 font-heading">Edit Jurnal Mengajar</h2>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $teacherJournal->status_badge }}">
                    {{ $teacherJournal->status_label }}
                </span>
            </div>
            
            <form action="{{ route('guru.journal.update', $teacherJournal) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ old('date', $teacherJournal->date->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('date') border-red-500 @enderror" required>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select name="class_id" id="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('class_id') border-red-500 @enderror" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('class_id', $teacherJournal->class_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mata Pelajaran -->
                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                        <select name="subject_id" id="subject_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('subject_id') border-red-500 @enderror" required>
                            <option value="">Pilih Mapel</option>
                            @foreach($mapels as $m)
                                <option value="{{ $m->id }}" {{ old('subject_id', $teacherJournal->subject_id) == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Materi -->
                    <div class="md:col-span-2">
                        <label for="topic" class="block text-sm font-medium text-gray-700">Materi Pembelajaran</label>
                        <input type="text" name="topic" id="topic" value="{{ old('topic', $teacherJournal->topic) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('topic') border-red-500 @enderror" required>
                        @error('topic')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Metode -->
                    <div class="md:col-span-2">
                        <label for="method" class="block text-sm font-medium text-gray-700">Metode Pembelajaran</label>
                        <input type="text" name="method" id="method" value="{{ old('method', $teacherJournal->method) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('method') border-red-500 @enderror" required>
                        @error('method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kehadiran -->
                    <div>
                        <label for="present_count" class="block text-sm font-medium text-gray-700">Jumlah Hadir</label>
                        <input type="number" name="present_count" id="present_count" value="{{ old('present_count', $teacherJournal->present_count) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('present_count') border-red-500 @enderror" required>
                        @error('present_count')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="absent_count" class="block text-sm font-medium text-gray-700">Jumlah Tidak Hadir</label>
                        <input type="number" name="absent_count" id="absent_count" value="{{ old('absent_count', $teacherJournal->absent_count) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('absent_count') border-red-500 @enderror" required>
                        @error('absent_count')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('notes', $teacherJournal->notes) }}</textarea>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="submit" name="status" value="draft" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Simpan Perubahan (Draft)
                    </button>
                    <button type="submit" name="status" value="sent" class="bg-primary-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" onclick="return confirm('Apakah Anda yakin ingin mengirim jurnal ini? Data tidak dapat diubah setelah dikirim.')">
                        Kirim Jurnal (Final)
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.portal>
