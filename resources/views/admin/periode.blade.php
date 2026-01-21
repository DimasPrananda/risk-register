<x-app-layout>
    <div x-data="{ open: false, showModal: false, selected: null, user: { id: null, bulan_awal: '', bulan_akhir: '' } }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Halaman Periode') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Periode</a>
        </x-slot>

        

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" text-right mb-5">

                <x-primary-button @click="
                    showModal = true;
                    user.id = null;
                    user.bulan_awal = '';
                    user.bulan_akhir = '';
                    ">
                    Tambah Periode
                </x-primary-button>
            </div>
            <table class=" w-full bg-white dark:bg-gray-800">
                <thead class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
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
                            {{ \Carbon\Carbon::parse($periode->bulan_awal)->translatedFormat('M') }}
                            –
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

                        <!-- Bulan Akhir -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Bulan Akhir
                            </label>
                            <input type="month"
                                    name="bulan_akhir"
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
