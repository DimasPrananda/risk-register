<x-app-layout>
    <div x-data="{
        open: false,
        showModal: false,
        selected: null, 
        kategori: { id: null, nama_kategori: '' }
    }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Halaman Kategori') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Kategori</a>
        </x-slot>

        <div class=" sm:px-6 lg:px-8">
            <form class="mb-4" action="{{ route('kategori.store') }}" method="POST" x-show="open" x-transition>
                @csrf
                <div class="mb-4">
                    <label for="nama_kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kategori:</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                </div>
                <x-primary-button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</x-primary-button>
            </form>
        </div>

        <div class="ml-20 max-w-7xl mx-auto bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-md shadow overflow-x-auto mb-4">
            <div class="flex justify-between">
                <h2 class="font-semibold text-gray-700 dark:text-gray-200 mb-2 p-4">Tabel Kategori</h2>
                <div class=" flex p-4">
                    <x-primary-button @click="
                        showModal = true;
                        kategori.id = null;
                        kategori.nama_kategori = '';
                        ">
                        Tambah Kategori
                    </x-primary-button>
                </div>
            </div>
            <div x-data="{
                page: 1,
                perPage: 10,
                total: {{ $kategoris->count() }},
                get pages() {
                    return Math.ceil(this.total / this.perPage)
                }
            }">
                <table class=" w-full bg-white dark:bg-gray-800">
                    <thead class="bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama Kategori</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 dark:text-gray-300">
                        @forelse ($kategoris as $index => $kategori)
                        <tr x-show="Math.ceil({{ $index + 1 }} / perPage) === page"
                            x-transition>
                            <td class=" text-center px-4 py-2">{{ $loop->iteration }} .</td>
                            <td class=" text-left px-4 py-2">{{ $kategori->nama_kategori }}</td>
                            <td class=" text-center px-4 py-2">
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus
                                    </x-danger-button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4">
                                <div class="w-full flex justify-center items-center text-sm text-gray-400">
                                    Tidak ada kategori ditemukan.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex justify-between items-center text-sm p-4 dark:bg-gray-800">
                    <span class="text-gray-500">
                        Page <span x-text="page"></span> of <span x-text="pages"></span>
                    </span>

                    <div class="flex gap-1">
                        <button
                            @click="page > 1 && page--"
                            :disabled="page === 1"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest
                            hover:bg-gray-700 dark:hover:bg-white
                            focus:bg-gray-700 dark:focus:bg-white
                            active:bg-gray-900 dark:active:bg-gray-300
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800
                            transition ease-in-out duration-150
                            disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Prev
                        </button>

                        <template x-for="p in pages" :key="p">
                            <button
                                @click="page = p"
                                class="px-3 py-1 rounded"
                                :class="page === p ? 'bg-blue-600 text-white' : 'bg-gray-200'"
                                x-text="p"
                            ></button>
                        </template>

                        <button
                            @click="page < pages && page++"
                            :disabled="page === pages"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest
                            hover:bg-gray-700 dark:hover:bg-white
                            focus:bg-gray-700 dark:focus:bg-white
                            active:bg-gray-900 dark:active:bg-gray-300
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800
                            transition ease-in-out duration-150
                            disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Next
                        </button>
                    </div>
                </div>
                <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.self="showModal = false">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
                        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Tambahkan Kategori</h2>

                        <form action="{{ route('kategori.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kategori:</label>
                                <input type="text" name="nama_kategori" id="nama_kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Simpan Kategori
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
