<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Halaman Dinamis</h1>
            <p class="text-gray-500">Kelola halaman dengan editor WYSIWYG</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Halaman
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pages as $page)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $page->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">/page/{{ $page->slug }}</td>
                        <td class="px-6 py-4 text-center">
                            <button wire:click="togglePublish({{ $page->id }})" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $page->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $page->is_published ? 'Published' : 'Draft' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="/page/{{ $page->slug }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <button wire:click="edit({{ $page->id }})" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button wire:click="confirmDelete({{ $page->id }})" class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada halaman</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($pages->hasPages())<div class="px-6 py-4 border-t">{{ $pages->links('vendor.pagination.tailwind') }}</div>@endif
    </div>

    {{-- WYSIWYG Editor Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ initEditor: false }" x-init="initEditor = true">
            <div class="flex items-start justify-center min-h-screen px-4 pt-4 pb-20">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full mt-8">
                    <form wire:submit="save">
                        <div class="px-6 py-4 border-b flex justify-between items-center">
                            <h3 class="text-lg font-semibold">{{ $editingId ? 'Edit' : 'Tambah' }} Halaman</h3>
                            <button type="button" wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Halaman</label>
                                    <input type="text" wire:model.live="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Tentang Kami">
                                    @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug URL</label>
                                    <div class="flex items-center">
                                        <span class="px-3 py-2 bg-gray-100 border border-r-0 border-gray-300 rounded-l-lg text-gray-500 text-sm">/page/</span>
                                        <input type="text" wire:model="slug" class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="tentang-kami">
                                    </div>
                                    @error('slug')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konten Halaman</label>
                                <div wire:ignore>
                                    <div id="editor" class="min-h-[300px] border border-gray-300 rounded-lg">{!! $content !!}</div>
                                </div>
                                <textarea wire:model="content" id="content-input" class="hidden"></textarea>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model="is_published" id="is_published" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                <label for="is_published" class="ml-2 text-sm text-gray-700">Publish halaman ini</label>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t bg-gray-50 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-700">Batal</button>
                            <button type="submit" onclick="syncEditorContent()" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showDeleteModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6 text-center">
                    <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <h3 class="text-lg font-semibold mb-2">Hapus Halaman?</h3>
                    <p class="text-gray-500 mb-6">Halaman yang dihapus tidak dapat dikembalikan.</p>
                    <div class="flex justify-center space-x-3">
                        <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-700">Batal</button>
                        <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script>
        let quill = null;
        
        document.addEventListener('livewire:navigated', initQuill);
        
        function initQuill() {
            const editorEl = document.getElementById('editor');
            if (editorEl && !quill) {
                quill = new Quill('#editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            [{ 'align': [] }],
                            ['link', 'image'],
                            ['clean']
                        ]
                    }
                });
            }
        }
        
        function syncEditorContent() {
            if (quill) {
                const content = quill.root.innerHTML;
                @this.set('content', content);
            }
        }
        
        Livewire.on('modalOpened', () => {
            setTimeout(initQuill, 100);
        });
    </script>
    @endpush
</div>
