<x-app-layout>
    <div x-data="{ open: false, showModal: false, selected: null, user: { id: null, bulan_awal: '', bulan_akhir: '' } }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Halaman Periode') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Periode</a>
        </x-slot>

        

        <div class="ml-20 max-w-7xl mx-auto bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-md shadow overflow-x-auto mb-4">
            <div class=" flex justify-between">
                <h2 class="font-semibold text-gray-700 dark:text-gray-200 mb-2 p-4">Tabel Periode</h2>
                <div class="flex p-4">
                    <x-primary-button @click="
                        showModal = true;
                        user.id = null;
                        user.bulan_awal = '';
                        user.bulan_akhir = '';
                        ">
                        Tambah Periode
                    </x-primary-button>
                </div>
            </div>
            <div x-data="{
                page: 1,
                perPage: 10,
                total: {{ $periodes->count() }},
                get pages() {
                    return Math.ceil(this.total / this.perPage)
                }
            }">
                <table class=" w-full bg-white dark:bg-gray-800">
                    <thead class="bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Periode</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 dark:text-gray-300">
                        @forelse ($periodes as $index => $periode)
                        <tr>
                            <td class=" text-center px-4 py-2">{{ $loop->iteration }} .</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($periode->bulan_akhir)->translatedFormat('M Y') }}
                            </td>
                            <td class=" flex justify-center text-center px-4 py-2 gap-2">
                                {{-- <x-secondary-button @click="showModal = true; periode.id = '{{ $periode->id }}'; periode.bulan_awal = '{{ $periode->bulan_awal }}'; periode.bulan_akhir = '{{ $periode->bulan_akhir }}'">
                                    Edit
                                </x-secondary-button> --}}
                                <form action="{{ route('periode.destroy', $periode->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?');">
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
                                    Tidak ada user ditemukan.
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
            </div>
            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.self="showModal = false">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
                    <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Tambahkan Periode</h2>

                    <form action="{{ route('periode.store') }}" method="POST">
                        @csrf

                        <!-- Bulan Awal -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Bulan Awal
                            </label>
                            <input type="month"
                                    name="bulan_awal"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200"
                                    required>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Simpan Periode
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
