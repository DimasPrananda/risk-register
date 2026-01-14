<x-app-layout>
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <table class=" w-full bg-white dark:bg-gray-800">
            <thead class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama Kategori</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-300">
                @forelse ($kategoris as $index => $kategori)
                <tr>
                    <td class=" text-center px-4 py-2">{{ $loop->iteration }} .</td>
                    <td class=" text-center px-4 py-2">{{ $kategori->nama_kategori }}</td>
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
    </div>
</x-app-layout>
