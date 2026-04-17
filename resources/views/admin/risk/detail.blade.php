<x-app-layout>
    <div x-data="{ open: false, openSebabId: null, showModal: false, addPerlakuanId: null, editPerlakuanId: null, editId: null, selected: null, sebab_risiko: { id: null, nama_sebab: '', pengendalian_internal: '', referensi_pengendalian: '', efektifitas_pengendalian: '', dampak_sebab: '', dampak: '', probabilitas: '', kategori_id: '' } }">
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
            </span>
            <span class=" text-gray-800 dark:text-gray-200 font-bold truncate max-w-md inline-block align-bottom">
                / {{ $sasaran->nama_sasaran }}
            </span>
        </x-slot>

        <div class="ml-20 max-w-7xl mx-auto overflow-x-auto mb-4 p-1">
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

                    {{-- ================= RISIKO KORPORAT ================= --}}
                    <div class="font-semibold text-gray-600 dark:text-gray-400">
                        Risiko Korporat
                    </div>
                    <div class="sm:col-span-2">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                            <div>
                                <div class="text-xs text-gray-500">Taksonomi</div>
                                <div class="font-medium">
                                    {{ $sasaran->taksonomi->nama ?? '-' }}
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        {{ $sasaran->parameter->bobot }}%
                                    </span>
                                </div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">Peristiwa Risiko</div>
                                <div class="font-medium">
                                    {{ $sasaran->peristiwaRisiko->nama ?? '-' }}
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        {{ $sasaran->parameter->bobot }}%
                                    </span>
                                </div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">Parameter Risiko</div>
                                <div class="font-medium">
                                    {{ $sasaran->parameter->nama ?? '-' }}
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        {{ $sasaran->parameter->bobot }}%
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class=" text-right my-5 flex justify-end gap-3">
                <a href="{{ route('sasaran.export', $sasaran->id) }}"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Download Excel
                </a>
                @if(!$sasaran->is_published)
                    <form method="POST" action="{{ route('sasaran.publish', $sasaran->id) }}"
                        onsubmit="return confirm('Yakin publish sasaran ini? Data akan tampil di dashboard.')">
                        @csrf
                        <x-primary-button class="bg-green-600 hover:bg-green-700">
                            Publish Sasaran
                        </x-primary-button>
                    </form>
                @else
                    <span class="inline-flex items-center px-4 py-2
                        bg-green-100 text-green-700 rounded-md text-sm font-semibold">
                        ✅ Published
                    </span>

                    {{-- Opsional --}}
                    <form method="POST" action="{{ route('sasaran.unpublish', $sasaran->id) }}">
                        @csrf
                        <x-secondary-button type="submit">
                            Unpublish
                        </x-secondary-button>
                    </form>
                @endif
                @if($sasaran->is_published)
                    <x-primary-button
                        disabled
                        class="opacity-50 cursor-not-allowed"
                        title="Sasaran sudah dipublish, tidak bisa menambah risiko">
                        Tambah Sebab Risiko
                    </x-primary-button>
                @else
                    <x-primary-button
                        @click="
                            showModal = true;
                            sebab_risiko.id = null;
                            sebab_risiko.nama_sebab = '';
                            sebab_risiko.pengendalian_internal = '';
                            sebab_risiko.referensi_pengendalian = '';
                            sebab_risiko.efektifitas_pengendalian = '';
                            sebab_risiko.dampak_sebab = '';
                            sebab_risiko.dampak = '';
                            sebab_risiko.probabilitas = '';
                            sebab_risiko.kategori_id = '';
                        ">
                        Tambah Sebab Risiko
                    </x-primary-button>
                @endif
            </div>
            @if($sasaran->sebabRisikos->count())
                @foreach($sasaran->sebabRisikos as $item)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm mb-4 sm:rounded-lg p-6">
                        <div class="flex justify-between items-center font-semibold text-xl gap-2 
                            cursor-pointer
                            hover:bg-gray-100 dark:hover:bg-gray-700
                            hover:shadow
                            rounded-lg
                            transition
                            p-2 -m-2"
                            @click="openSebabId = openSebabId === {{ $item->id }} ? openSebabId = null : openSebabId = {{ $item->id }}"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 dark:text-gray-200 text-xl">{{ $loop->iteration }}. {{ $item->nama_sebab }}</p>                                
                            </div>
                            <svg
                                class="w-5 h-5 text-gray-400 transition-transform duration-300"
                                :class="openSebabId === {{ $item->id }} ? 'rotate-90 text-blue-500' : ''"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            <div class="shrink-0" @click.stop>
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
                                        @click="{{ $sasaran->is_published ? '' : 'editId = '.$item->id }}"
                                        class="{{ $sasaran->is_published ? 'opacity-50 pointer-events-none cursor-not-allowed' : '' }}">
                                        Edit
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('risk.detail.destroy', $sasaran->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <input type="hidden" name="sebab_risiko_id" value="{{ $item->id }}">

                                        <x-dropdown-link
                                            href="#"
                                            class="{{ $sasaran->is_published ? 'opacity-50 pointer-events-none cursor-not-allowed' : '' }}"
                                            onclick="{{ $sasaran->is_published ? 'return false;' : 'event.preventDefault(); this.closest(\'form\').submit();' }}">
                                            Hapus
                                        </x-dropdown-link>
                                    </form>
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
                                    Dampak:
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    {{ $item->dampak_sebab }}
                                </span>
                            </p>

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
                                    Pengendalian Risiko
                                </p>

                                @foreach($item->perlakuanRisikos as $perlakuan)
                                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 mb-3 bg-gray-50 dark:bg-gray-800">
                                        
                                        <div class="flex justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                    <span class="font-medium text-gray-700 dark:text-gray-300">
                                                        Pengendalian Risiko:
                                                    </span>
                                                    <span class="text-gray-500 dark:text-gray-400">
                                                        {{ $perlakuan->perlakuan_risiko }}
                                                    </span>
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
                                                        <x-dropdown-link
                                                            @click="{{ $sasaran->is_published ? '' : 'editPerlakuanId = '.$perlakuan->id }}"
                                                            class="{{ $sasaran->is_published ? 'opacity-50 pointer-events-none cursor-not-allowed' : '' }}">
                                                            Edit
                                                        </x-dropdown-link>

                                                        <form method="POST" action="{{ route('risk.perlakuan-risiko.destroy', $item->id) }}">
                                                            @csrf
                                                            @method('DELETE')

                                                            <input type="hidden" name="perlakuan_risiko_id" value="{{ $perlakuan->id }}">

                                                            <x-dropdown-link
                                                                href="#"
                                                                class="{{ $sasaran->is_published ? 'opacity-50 pointer-events-none cursor-not-allowed' : '' }}"
                                                                onclick="{{ $sasaran->is_published 
                                                                    ? 'return false;' 
                                                                    : 'event.preventDefault(); this.closest(\'form\').submit();' }}">
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
                                        </div>

                                        <div>
                                            <table x-data="{ open: false }" class="w-full border border-gray-400 text-sm text-center mt-2">
                                                @include('admin.risk.partials.table-realisasi', [
                                                    'output_target' => $perlakuan->output_target,
                                                    'output_realisasi' => $perlakuan->output_realisasi,
                                                    'periode' => $perlakuan->periode,
                                                    'timeline_realisasi' => $perlakuan->timeline_realisasi,
                                                    'biaya_target' => $perlakuan->biaya_target,
                                                    'biaya_realisasi' => $perlakuan->biaya_realisasi,
                                                ]) 
                                            </table>
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
                                        {{-- KOMENTAR --}}
                                        <div class="mt-3 p-3 rounded-md bg-white dark:bg-gray-800">
                                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                Komentar
                                            </p>

                                            <div>
                                                @if($perlakuan->komentars && $perlakuan->komentars->isNotEmpty())
                                                    @foreach($perlakuan->komentars as $komentar)
                                                        <div class=" flex justify-between mb-2 text-sm border-b pb-1">
                                                            <div>
                                                                <span class="font-semibold dark:text-gray-200">
                                                                    {{ $komentar->user->name }}
                                                                </span>
                                                                <span class="text-xs text-gray-400">
                                                                    • {{ $komentar->created_at->diffForHumans() }}
                                                                </span>
                                                                <p class="mt-1 dark:text-gray-200">
                                                                    {{ $komentar->isi }}
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
                                                                        <form method="POST" action="{{ route('risk.komentar.destroy', $komentar->id) }}">
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
                                                        
                                                    @endforeach
                                                @else
                                                    <p class="text-xs text-gray-400">Belum ada komentar</p>
                                                @endif
                                                
                                            </div>
                                                    
                                            {{-- FORM TAMBAH KOMENTAR --}}
                                            <form method="POST" action="{{ route('risk.komentar.store', $perlakuan->id) }}" class="mt-2">
                                                @csrf
                                                <textarea
                                                    name="isi"
                                                    rows="2"
                                                    class="w-full text-sm rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Tulis komentar..."
                                                ></textarea>
        
                                                <div class="flex justify-end mt-2">
                                                    <button
                                                        type="submit"
                                                        class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                        Kirim
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @include('admin.risk.partials.modal-edit-perlakuan', [
                                        'perlakuan' => $perlakuan,
                                        'item' => $item
                                    ])
                                    @endforeach
                                    
                                </div>
                                @else
                                <p class="flex mt-4 text-gray-400 justify-center text-sm">Belum ada pengendalian risiko</p>
                                @endif
                            <div>
                                <x-primary-button
                                    class=" mt-4"
                                    @click="addPerlakuanId = {{ $item->id }};">
                                    Tambah Pengendalian
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