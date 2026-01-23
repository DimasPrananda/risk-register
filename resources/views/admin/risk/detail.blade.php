<x-app-layout>
    <div x-data="{ open: false, showModal: false, selected: null, sebab_risiko: { id: null, nama_sebab: '', pengendalian_internal: '', referensi_pengendalian: '', efektifitas_pengendalian: '', dampak: '', probabilitas: '', kategori_id: '' } }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Halaman Detail Sasaran') }}
            </h2>

            <a href="{{ route('admin.dashboard') }}"
            class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">
                dashboard
            </a>

            <span class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">
                / Pilih Periode /
                {{ \Carbon\Carbon::parse($periode->bulan_awal)->translatedFormat('F Y') }}
                -
                {{ \Carbon\Carbon::parse($periode->bulan_akhir)->translatedFormat('F Y') }}
            </span>
            <span class=" text-gray-800 dark:text-gray-200 font-bold truncate max-w-md inline-block align-bottom">
                / {{ $sasaran->nama_sasaran }}
            </span>
        </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-2 text-gray-900 dark:text-gray-100">

                    <div class="font-semibold text-gray-600 dark:text-gray-400">
                        Nama Sasaran
                    </div>
                    <div class="sm:col-span-2">
                        {{ $sasaran->nama_sasaran }}
                    </div>

                    <div class="font-semibold text-gray-600 dark:text-gray-400">
                        Target
                    </div>
                    <div class="sm:col-span-2">
                        {{ $sasaran->target }}
                    </div>

                    <div class="font-semibold text-gray-600 dark:text-gray-400">
                        Risiko
                    </div>
                    <div class="sm:col-span-2">
                        {{ $sasaran->risiko }}
                    </div>
                    
                    <div class="font-semibold text-gray-600 dark:text-gray-400">
                        Dampak
                    </div>
                    <div class="sm:col-span-2">
                        {{ $sasaran->dampak }}
                    </div>
                </div>
            </div>
            <div class=" text-right my-5">
                <x-primary-button @click="
                    showModal = true;
                    sebab_risiko.id = null;
                    sebab_risiko.nama_sebab = '';
                    sebab_risiko.pengendalian_internal = '';
                    sebab_risiko.referensi_pengendalian = '';
                    sebab_risiko.efektifitas_pengendalian = '';
                    sebab_risiko.dampak = '';
                    sebab_risiko.probabilitas = '';
                    sebab_risiko.kategori_id = '';
                    ">
                    Tambah Sebab Risiko
                </x-primary-button>
            </div>
            @if($sasaran->sebabRisikos->count())
                @foreach($sasaran->sebabRisikos as $item)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm mb-4 sm:rounded-lg p-6">
                        <div class="flex justify-between items-start font-semibold text-xl gap-2">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 dark:text-gray-200 text-xl">{{ $item->nama_sebab }}</p>
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
                                        <x-dropdown-link
                                            href="#"
                                            @click.prevent="
                                                showModal = true;
                                                sebab_risiko.id = {{ $item->id }};
                                                sebab_risiko.nama_sebab = '{{ $item->nama_sebab }}';
                                                sebab_risiko.pengendalian_internal = '{{ $item->pengendalian_internal }}';
                                                sebab_risiko.referensi_pengendalian = '{{ $item->referensi_pengendalian }}';
                                                sebab_risiko.efektifitas_pengendalian = '{{ $item->efektifitas_pengendalian }}';
                                                sebab_risiko.dampak = '{{ $item->dampak }}';
                                                sebab_risiko.probabilitas = '{{ $item->probabilitas }}';
                                                sebab_risiko.kategori_id = {{ $item->kategori_id }};
                                            ">
                                            Edit
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('risk.detail.destroy', $sasaran->id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="sebab_risiko_id" value="{{ $item->id }}">

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
                        <p class="text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                Pengendalian Internal:
                            </span>
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ $item->pengendalian_internal }}
                            </span>
                        </p>

                        <p class="text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                Referensi:
                            </span>
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ $item->referensi_pengendalian }}
                            </span>
                        </p>

                        <p class="text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                Efektifitas:
                            </span>
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ $item->efektifitas_pengendalian }}
                            </span>
                        </p>
                        <div class="overflow-x-auto">
                            <table class="w-full border border-gray-400 text-sm text-center">
                                <thead>
                                    <tr>
                                        <th colspan="4"
                                            class="border border-gray-400 px-4 py-2 font-semibold bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                                            Target Tingkat Risiko Inherent (TR Inherent)
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 dark:bg-gray-800">
                                        <th class="border border-gray-400 dark:text-gray-2 px-4 py-2">Dampak</th>
                                        <th class="border border-gray-400 dark:text-gray-2 px-4 py-2">Probabilitas</th>
                                        <th class="border border-gray-400 dark:text-gray-2 px-4 py-2">Skala Risiko</th>
                                        <th class="border border-gray-400 dark:text-gray-2 px-4 py-2">Level Risiko</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 dark:text-gray-200">
                                    <tr>
                                        <td class="border border-gray-400 px-4 py-2 text-center">
                                            {{ $item['dampak'] ?? '-' }}
                                        </td>

                                        <td class="border border-gray-400 px-4 py-2 text-center">
                                            {{ $item['probabilitas'] ?? '-' }}
                                        </td>

                                        <td class="border border-gray-400 px-4 py-2 text-center font-semibold">
                                            {{ $item['skala_risiko'] ?? '-' }}
                                        </td>

                                        <td class="border border-gray-400 px-4 py-2 text-center font-semibold">
                                            @if($item['level_risiko'] === 'High')
                                                <span class="flex flex-1 justify-center rounded-lg bg-red-600 text-white">{{ $item['level_risiko'] }}</span>
                                            @elseif($item['level_risiko'] === 'Moderate to High')
                                                <span class="flex flex-1 justify-center rounded-lg bg-orange-500 text-white">{{ $item['level_risiko'] }}</span>
                                            @elseif($item['level_risiko'] === 'Moderate')
                                                <span class="flex flex-1 justify-center rounded-lg bg-yellow-500 text-white">{{ $item['level_risiko'] }}</span>
                                            @elseif($item['level_risiko'] === 'Low to Moderate')
                                                <span class="flex flex-1 justify-center rounded-lg bg-green-500 text-white">{{ $item['level_risiko'] }}</span>
                                            @elseif($item['level_risiko'] === 'Low')
                                                <span class="flex flex-1 justify-center rounded-lg bg-green-700 text-white">{{ $item['level_risiko'] }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-400 text-sm">Belum ada sebab risiko</p>
            @endif
            <div x-show="showModal"
                x-transition
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                @click.self="showModal = false">

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6">

                    <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
                        Tambah Sebab Risiko
                    </h2>

                    <form action="{{ route('risk.detail.store', $sasaran) }}" method="POST">
                        @csrf

                        <!-- SASARAN -->
                        <input type="hidden" name="sasaran_id" value="{{ $sasaran->id }}">

                        <!-- KATEGORI -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Kategori Risiko
                            </label>
                            <select name="kategori_id"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        dark:bg-gray-700 dark:text-gray-200"
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- NAMA SEBAB -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Sebab Risiko
                            </label>
                            <textarea name="nama_sebab"
                                    rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200"
                                    required></textarea>
                        </div>

                        <!-- PENGENDALIAN INTERNAL -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Pengendalian Internal
                            </label>
                            <textarea name="pengendalian_internal"
                                    rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200"
                                    required></textarea>
                        </div>

                        <!-- REFERENSI -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Referensi Pengendalian
                            </label>
                            <input type="text"
                                name="referensi_pengendalian"
                                class="mt-1 block w-full rounded-md border-gray-300
                                        dark:bg-gray-700 dark:text-gray-200"
                                required>
                        </div>

                        <!-- EFEKTIFITAS -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Efektifitas Pengendalian
                            </label>
                            <select name="efektifitas_pengendalian"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        dark:bg-gray-700 dark:text-gray-200"
                                    required>
                                <option value="">-- Pilih --</option>
                                <option value="Efektif">Efektif</option>
                                <option value="Kurang Efektif">Kurang Efektif</option>
                                <option value="Tidak Efektif">Tidak Efektif</option>
                            </select>
                        </div>

                        <!-- DAMPAK & PROBABILITAS -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Dampak
                                </label>
                                <input type="number"
                                    name="dampak"
                                    min="1" max="5"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Probabilitas
                                </label>
                                <input type="number"
                                    name="probabilitas"
                                    min="1" max="5"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                            dark:bg-gray-700 dark:text-gray-200">
                            </div>
                        </div>

                        <!-- ACTION -->
                        <div class="mt-6 flex justify-end gap-2">
                            <button type="button"
                                    @click="showModal = false"
                                    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                                Batal
                            </button>

                            <button type="submit"
                                    class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        
    </div>
</x-app-layout>