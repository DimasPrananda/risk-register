<x-app-layout>
    <div x-data="{ open: false, showModal: false, selected: null, sasaran: { id: null, nama_sasaran: '', target: '', risiko: '', dampak: '' } }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Halaman Sasaran') }}
            </h2>

            <a href="{{ route('admin.dashboard') }}"
            class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">
                dashboard
            </a>

            <span class="text-gray-800 dark:text-gray-200 font-bold">
                / Pilih Periode /
                {{ \Carbon\Carbon::parse($periode->bulan_awal)->translatedFormat('F Y') }}
                -
                {{ \Carbon\Carbon::parse($periode->bulan_akhir)->translatedFormat('F Y') }}
            </span>
        </x-slot>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" text-right mb-5">

                <x-primary-button @click="
                    showModal = true;
                    sasaran.id = null;
                    sasaran.nama_sasaran = '';
                    sasaran.target = '';
                    sasaran.risiko = '';
                    sasaran.dampak = '';
                    ">
                    Tambah Sasaran
                </x-primary-button>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class=" bg-white dark:bg-gray-800 p-4">
                        @foreach($departemens as $departemen)
                            <div class="mb-6">
                                <!-- Nama Departemen -->
                                <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-2">
                                    {{ $departemen->nama_departemen }}
                                </h4>

                                <div class=" flex flex-1">
                                    @if($departemen->sasarans->count())
                                        <div class="ml-4 grid grid-cols-2 gap-4 w-3/4 h-72">
                                            @foreach($departemen->sasarans as $sasaran)
                                                <div class="flex flex-1 flex-col border rounded p-3 bg-gray-50 dark:bg-gray-700">
                                                    <div class="flex justify-between items-start font-semibold text-xl gap-2">
                                                        <div class="flex-1 min-w-0">
                                                            <p class="truncate">
                                                                {{ $sasaran->nama_sasaran }}
                                                            </p>
                                                        </div>

                                                        <div class="shrink-0">
                                                            <x-dropdown>
                                                                <x-slot name="trigger">
                                                                    <button class="p-1">
                                                                        <img src="{{ asset('icons/menu_vertical.svg') }}"
                                                                            class="w-4 h-4"
                                                                            alt="Icon menu vertical">
                                                                    </button>
                                                                </x-slot>

                                                                <x-slot name="content">
                                                                    <form method="POST" action="{{ route('risk.sasaran.destroy', $sasaran) }}">
                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <x-dropdown-link
                                                                            href="#"
                                                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                                                            Hapus
                                                                        </x-dropdown-link>
                                                                    </form>
                                                                </x-slot>
                                                            </x-dropdown>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs font-normal text-gray-400">
                                                        Dibuat: {{ $sasaran->created_at->format('d/m/Y') }}
                                                    </span>
                                                    <div class="flex flex-col text-sm text-gray-600 dark:text-gray-300">
                                                        <h3>
                                                            Target: {{ $sasaran->target }}
                                                        </h3>
                                                        <h3>
                                                            Risiko: {{ $sasaran->risiko }}
                                                        </h3>
                                                        <h3>
                                                            Dampak: {{ $sasaran->dampak }}
                                                        </h3>
                                                    </div>
                                                    <div class=" mt-auto flex items-end">
                                                        <x-secondary-button href="{{ route('risk.detail', $sasaran) }}"
                                                            class="text-blue-600 dark:text-blue-400 w-full justify-center">
                                                            Lihat Detail                                                        
                                                        </x-secondary-button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="ml-4 text-sm text-gray-400">Belum ada sasaran</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.self="showModal = false">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
                    <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Tambahkan Sasaran</h2>

                    <form action="{{ route('risk.sasaran.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Nama Sasaran
                            </label>
                            <input type="text"
                                    name="nama_sasaran"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200"
                                    required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Target
                            </label>
                            <input type="text"
                                    name="target"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200"
                                    required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Risiko
                            </label>
                            <input type="text"
                                    name="risiko"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200"
                                    required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Dampak
                            </label>
                            <input type="text"
                                    name="dampak"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200"
                                    required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Departemen
                            </label>
                            <select name="departemen_id"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        dark:bg-gray-700 dark:text-gray-200"
                                    required>
                                <option value="">-- Pilih Departemen --</option>
                                @foreach($departemens as $departemen)
                                    <option value="{{ $departemen->id }}">
                                        {{ $departemen->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Simpan Sasaran
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
