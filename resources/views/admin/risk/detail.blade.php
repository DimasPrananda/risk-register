<x-app-layout>
    <div x-data="{ open: false, openSebabId: null, showModal: false, addPerlakuanId: null, editPerlakuanId: null, editId: null, selected: null, sebab_risiko: { id: null, nama_sebab: '', pengendalian_internal: '', referensi_pengendalian: '', efektifitas_pengendalian: '', dampak: '', probabilitas: '', kategori_id: '' } }">
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
                        <div class="flex justify-between items-start font-semibold text-xl gap-2 cursor-pointer"
                            @click="openSebabId = openSebabId === {{ $item->id }} ? openSebabId = null : openSebabId = {{ $item->id }}">
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
                                        <x-dropdown-link @click="editId = {{ $item->id }}">
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
                        <div x-show="openSebabId === {{ $item->id }}"
                            x-collapse
                            x-cloak
                            class="mt-4">

                            <p class=" font-semibold">
                                <span class=" text-gray-700 dark:text-gray-300">
                                    Pengendalian Internal:
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    {{ $item->pengendalian_internal }}
                                </span>
                            </p>

                            <p class=" font-semibold">
                                <span class=" text-gray-700 dark:text-gray-300">
                                    Kategori Risiko:
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    {{ $item->kategori->nama_kategori }}
                                </span>
                            </p>

                            <p class=" font-semibold">
                                <span class=" text-gray-700 dark:text-gray-300">
                                    Referensi:
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    {{ $item->referensi_pengendalian }}
                                </span>
                            </p>

                            <p class=" font-semibold">
                                <span class=" text-gray-700 dark:text-gray-300">
                                    Efektifitas:
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    {{ $item->efektifitas_pengendalian }}
                                </span>
                            </p>
                            <div class="overflow-x-auto">
                                <table class="w-full border border-gray-400 text-sm text-center">
                                    @include('admin.risk.partials.table-risiko', [
                                        'item' => [
                                            'dampak' => $item->dampak,
                                            'probabilitas' => $item->probabilitas,
                                            'skala_risiko' => $item->skala_risiko,
                                            'level_risiko' => $item->level_risiko,
                                        ]
                                    ])
                                </table>
                            </div>
                            @if($item->perlakuanRisikos->count())
                            <div class="mt-4 p-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700">
                                <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Perlakuan Risiko
                                </p>

                                @foreach($item->perlakuanRisikos as $perlakuan)
                                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 mb-3 bg-gray-50 dark:bg-gray-800">
                                        
                                        <div class="flex justify-between">
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                <span class="font-medium text-gray-700 dark:text-gray-300">
                                                    Perlakuan Risiko:
                                                </span>
                                                <span class="text-gray-500 dark:text-gray-400">
                                                    {{ $perlakuan->perlakuan_risiko }}
                                                </span>
                                            </p>

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
                                                        <x-dropdown-link @click="editPerlakuanId = {{ $perlakuan->id }}">
                                                            Edit
                                                        </x-dropdown-link>
                                                        <form method="POST" action="{{ route('risk.perlakuan-risiko.destroy', $item->id) }}">
                                                            @csrf
                                                            @method('DELETE')

                                                            <input type="hidden" name="perlakuan_risiko_id" value="{{ $perlakuan->id }}">

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
                                        

                                        <p class="font-semibold text-gray-800 dark:text-gray-200">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                                Jadwal Mitigasi:
                                            </span>                                        
                                        </p>

                                        <div class=" flex gap-4">
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                <span class="font-medium text-gray-700 dark:text-gray-300">
                                                    Periode:
                                                </span>  
                                                <span class=" font-semibold text-gray-400">
                                                    {{ $perlakuan->periode }}   
                                                </span>                                      
                                            </p>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                <span class="font-medium text-gray-700 dark:text-gray-300">
                                                    Tanggal: 
                                                </span> 
                                                <span class=" font-normal text-gray-400 text-sm">
                                                    {{ $perlakuan->created_at->format('d/m/Y') }}                                       
                                                </span>
                                            </p>
                                        </div>

                                        <div class="overflow-x-auto mt-2">
                                            <table class="w-full border border-gray-400 text-sm text-center">
                                                @include('admin.risk.partials.table-perlakuan', [
                                                    'dampak' => $perlakuan->dampak,
                                                    'probabilitas' => $perlakuan->probabilitas,
                                                    'skala_risiko' => $perlakuan->skala_risiko,
                                                    'level_risiko' => $perlakuan->level_risiko,
                                                ])
                                            </table>
                                        </div>
                                        @if($perlakuan->dokumen_pdf)
                                            <a href="{{ asset('storage/'.$perlakuan->dokumen_pdf) }}"
                                            target="_blank"
                                            class="text-blue-600 underline text-sm">
                                                Lihat Dokumen (PDF)
                                            </a>
                                        @endif
                                    </div>
                                    @include('admin.risk.partials.modal-edit-perlakuan', [
                                        'perlakuan' => $perlakuan,
                                        'item' => $item
                                    ])
                                    @endforeach
                                </div>
                                @else
                                <p class="flex mt-4 text-gray-400 justify-center text-sm">Belum ada perlakuan risiko</p>
                                @endif
                            <div>
                                <x-primary-button
                                    class=" mt-4"
                                    @click="addPerlakuanId = {{ $item->id }};">
                                    Tambah Perlakuan
                                </x-primary-button>
                            </div>
                        </div>
                        
                    </div>
                    @include('admin.risk.partials.modal-edit-risiko', [
                        'sasaran' => $sasaran,
                        'kategoris' => $kategoris,
                        'item' => $item
                    ])
                    @include('admin.risk.partials.modal-create-perlakuan', [
                        'item' => $item
                    ])            
                @endforeach
            @else
                <p class="text-gray-400 text-sm">Belum ada sebab risiko</p>
            @endif
            
        </div>
        
        @include('admin.risk.partials.modal-create-risiko', [
            'sasaran' => $sasaran,
            'kategoris' => $kategoris
        ])
    </div>
</x-app-layout>