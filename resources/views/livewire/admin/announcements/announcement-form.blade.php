<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">{{ $announcementId ? 'Edit Berita' : 'Tambah Berita Baru' }}</h1>
            <p class="text-gray-500">Tulis dan terbitkan informasi terbaru untuk pesantren.</p>
        </div>
        <a href="{{ route('admin.announcements.index') }}" class="btn-secondary inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 md:p-8 space-y-6">
                
                <!-- Judul -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="title" class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-primary-500 focus:border-primary-500 sm:text-lg font-medium" placeholder="Masukkan judul berita yang menarik...">
                    @error('title') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Gambar Thumbnail -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar Thumbnail Banner (Opsional)</label>
                    <div class="flex flex-col sm:flex-row gap-6 items-start">
                        <div class="w-full sm:w-64">
                            @if($image)
                                <div class="w-full aspect-video rounded-lg border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                </div>
                            @elseif($existingImage)
                                <div class="w-full aspect-video rounded-lg border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $existingImage) }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-full aspect-video rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm">Belum ada gambar</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 w-full">
                            <input type="file" wire:model="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors">
                            <p class="mt-2 text-sm text-gray-500">Format yang didukung: JPG, PNG, WEBP. Maksimal ukuran 2MB.</p>
                            <div wire:loading wire:target="image" class="mt-2 text-sm text-primary-600 font-medium">Sedang mengupload...</div>
                            @error('image') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Excerpt (Ringkasan) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Ringkasan (Excerpt) <span class="text-gray-400 font-normal text-xs ml-1">(Opsional)</span></label>
                    <textarea wire:model="excerpt" rows="2" class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="Tulis ringkasan singkat untuk ditampilkan di halaman depan. Jika kosong, sistem akan mengambil kalimat pertama dari isi berita."></textarea>
                    @error('excerpt') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Rich Text Editor (Quill) -->
                <div wire:ignore>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Isi Berita <span class="text-red-500">*</span></label>
                    <!-- Include Quill setup -->
                    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                    <div id="quill-editor" class="bg-white" style="min-height: 350px;">
                        {!! $content !!}
                    </div>
                </div>
                @error('content') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror

                <!-- Status Aktif / Toggle -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">Status Publikasi</h4>
                        <p class="text-sm text-gray-500">Tentukan apakah berita ini langsung ditampilkan atau disimpan sebagai draft.</p>
                    </div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="sr-only peer">
                        <div class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                        <span class="ms-3 text-sm font-bold text-gray-700">{{ $is_active ? 'Publikasikan' : 'Draft' }}</span>
                    </label>
                </div>

            </div>
            <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('admin.announcements.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Berita
                </button>
            </div>
        </div>
    </form>

    <!-- Quill.js Initialization script -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Tulis isi berita selengkapnya di sini...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            // Update livewire property when quill content changes
            quill.on('text-change', function() {
                @this.set('content', quill.root.innerHTML);
            });
        });
    </script>
</div>
