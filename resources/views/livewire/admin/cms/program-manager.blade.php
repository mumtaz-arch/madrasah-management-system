<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            
            <h1 class="text-2xl font-bold mb-4 text-primary-700">Manajemen Program Unggulan</h1>

            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <button wire:click="create()" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded my-3">
                + Tambah Program
            </button>

            @if($isOpen)
                <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form wire:submit.prevent="store">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="mb-4">
                                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Program:</label>
                                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" wire:model="title" placeholder="Contoh: Tahfidzul Qur'an">
                                        @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" wire:model="description" placeholder="Deskripsi singkat..."></textarea>
                                        @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>
                                     <div class="mb-4">
                                        <label for="icon" class="block text-gray-700 text-sm font-bold mb-2">Icon Class (FontAwesome/Heroicon):</label>
                                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="icon" wire:model="icon" placeholder="fas fa-book">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Gambar:</label>
                                        <input type="file" wire:model="newImage" class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-primary-50 file:text-primary-700
                                          hover:file:bg-primary-100
                                        "/>
                                        @if ($newImage)
                                            <img src="{{ $newImage->temporaryUrl() }}" class="mt-2 h-20 w-auto rounded">
                                        @elseif($image)
                                            <img src="{{ asset('storage/'.$image) }}" class="mt-2 h-20 w-auto rounded">
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label class="flex items-center">
                                                <input type="checkbox" wire:model="is_featured" class="form-checkbox text-primary-600">
                                                <span class="ml-2 text-gray-700">Tampilkan di Depan</span>
                                            </label>
                                        </div>
                                        <div class="mb-4">
                                             <label for="sort_order" class="block text-gray-700 text-sm font-bold mb-2">Urutan:</label>
                                            <input type="number" wire:model="sort_order" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                        <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-primary-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-primary-500 focus:outline-none focus:border-primary-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                            Simpan
                                        </button>
                                    </span>
                                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                        <button wire:click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                            Batal
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-primary-50 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Urutan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($programs as $program)
                        <tr>
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($program->image)
                                        <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ asset('storage/'.$program->image) }}">
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $program->title }}</div>
                                        @if($program->is_featured)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($program->description, 50) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $program->sort_order }}</td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <button wire:click="edit({{ $program->id }})" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
                                <button wire:click="delete({{ $program->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
