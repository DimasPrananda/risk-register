<x-app-layout>
    <div 
        x-data="{ activeDept: {{ $departemenAktif->id ?? 'null' }}, openSidebar: true }"
        class="flex max-w-7xl ml-0 md:ml-20 mx-auto"
    >

        <div class="flex w-full h-screen overflow-hidden">
            {{-- SIDEBAR --}}
            <aside 
                class="fixed mt-16 md:mt-0 md:sticky top-0 md:top-4 left-0 z-40
                    h-full md:h-[calc(100vh-5rem)]
                    w-64 md:w-80
                    bg-white dark:bg-gray-900
                    overflow-y-auto px-4 py-2
                    transform transition-transform duration-300"

                :class="openSidebar 
                    ? 'translate-x-0' 
                    : '-translate-x-full md:translate-x-0'"
            >
                @forelse($departemens as $dept)
                    <button
                        @click="activeDept = {{ $dept->id }}; openSidebar = false"
                        class="w-full text-left px-4 py-2 mb-2 rounded transition"
                        :class="activeDept === {{ $dept->id }}
                            ? 'inline-flex bg-gray-200 hover:bg-blue-100 font-semibold text-xs text-gray-700 dark:text-gray-800 uppercase tracking-widest' 
                            : 'inline-flex bg-gray-800 hover:bg-blue-100 font-semibold text-xs text-white dark:hover:text-gray-700 dark:text-gray-200 uppercase tracking-widest'"
                    >
                        {{ $dept->nama_departemen }}
                    </button>
                @empty
                    <p class="text-center text-sm text-gray-400 italic">
                        Tidak ada departemen ditemukan
                    </p>
                @endforelse
            </aside>
            <button
                @click="openSidebar = !openSidebar"
                class="fixed md:hidden top-1/2 -translate-y-1/2 z-50
                    bg-blue-600 text-white w-8 h-12 flex items-center justify-center
                    rounded-r-lg shadow-lg transition-all duration-300"

                :class="openSidebar ? 'left-64' : 'left-0'"
            >
                <span x-text="openSidebar ? '❮' : '❯'"></span>
            </button>


            {{-- CONTENT --}}
            <main class="flex-1 mx-4">

                @foreach($departemens as $dept)
                <section
                    x-show="activeDept === {{ $dept->id }}"
                    x-transition
                    x-cloak
                    x-data="{
                        cardPage: 1,
                        cardPerPage: 5,
                        totalCard: {{ $dept->sasarans->count() }},
                        get cardPages() {
                            return Math.ceil(this.totalCard / this.cardPerPage)
                        }
                    }"
                >

                <div class="sticky top-5 z-20 
                            bg-gray-100 dark:bg-gray-900 
                            px-3 py-3 md:p-0 
                            border-b md:border-0 dark:border-gray-700 w-full max-w-full">

                    <form method="GET" class=" w-full">
                        <input type="hidden" name="departemen_id" value="{{ $departemenAktif?->id }}">

                        <select
                            name="periode_id"
                            onchange="this.form.submit()"
                            class="w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white mb-4"
                        >
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->id }}"
                                    {{ optional($periodeAktif)->id === $periode->id ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($periode->bulan_awal)->translatedFormat('F Y') }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    {{-- RESIDUAL SUMMARY --}}
                    @include('admin.dashboard.residual-summary')
                </div>
                <div class=" py-6 space-y-6 overflow-y-auto max-h-[calc(100vh-16rem)]">
                    {{-- TABEL --}}
                    @forelse($dept->sasarans as $index=> $sasaran)
                        <div x-show="Math.ceil({{ $index + 1 }} / cardPerPage) === cardPage" x-transition class=" bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-md shadow overflow-x-auto mb-4"                    
                        >
                            <div class="flex ml-4 gap-2 items-center">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                            bg-gray-800 text-white dark:bg-gray-200 dark:text-gray-800 
                                            font-bold text-lg">
                                    {{ $index + 1 }}
                                </div>

                                <p class="font-semibold text-gray-700 dark:text-gray-200 mb-2 p-4">
                                    {{ $sasaran->risiko }}
                                </p>
                            </div>

                            {{-- TABLE --}}
                            <div x-data="{
                                page: 1,
                                perPage: 5,
                                total: {{ $sasaran->sebabRisikos->count() }},
                                get pages() {
                                    return Math.ceil(this.total / this.perPage)
                                }
                            }">
                                @include('admin.dashboard.table-dashboard', ['sasaran' => $sasaran])
                                @include('admin.dashboard.table-pagination')
                            </div>
                        </div>
                        @empty
                            <p class="p-4 text-gray-500">Sasaran belum ditentukan</p>
                        @endforelse 
                        
                        {{-- PAGINATION CARD --}}
                        @include('admin.dashboard.card-pagination')
                    
                    </section>
                    @endforeach
                </div>
            </main>
        </div>

        
        {{-- SIDEBAR KANAN PDF --}}
        <aside x-data="{
        index: 0,
        items: @js($pengumumen ?? []),

        get current() {
            return this.items[this.index]
        },

        next() {
            if (this.index < this.items.length - 1) this.index++
        },

        prev() {
            if (this.index > 0) this.index--
        },

        hapus() {
            if (!this.current) return

            if (!confirm('Yakin ingin menghapus pengumuman ini?')) return

            fetch(`/pengumuman/${this.current.id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(() => {
                this.items.splice(this.index, 1)

                if (this.index > this.items.length - 1) {
                    this.index = this.items.length - 1
                }

                if (this.index < 0) this.index = 0
            })
        }
    }"
    class="w-80 sticky top-20 mt-5 h-[calc(100vh-5rem)]
        p-4 dark:bg-gray-900
        border-l dark:border-gray-700">
            
            <div class="flex justify-between items-center mb-3">
                <div class="flex justify-between items-center mb-2 gap-2">
                    {{-- LIGHT MODE --}}
                    <img
                        src="{{ asset('icons/commercial-gray.svg') }}"
                        class="block w-6 h-6 dark:hidden"
                        alt="commercial light"
                    >

                    {{-- DARK MODE --}}
                    <img
                        src="{{ asset('icons/commercial.svg') }}"
                        class="hidden w-6 h-6 dark:block"
                        alt="commercial dark"
                    >
                    <h3 class="font-semibold text-gray-700 dark:text-white text-sm">
                        Info
                    </h3>

                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-600"></span>
                    </span>

                    <div class="flex items-center gap-1">
                        <span class="text-xs text-gray-400">
                            <span x-text="index + 1"></span>/<span x-text="items.length"></span>
                        </span>
                    </div>
                </div>
                <div class=" flex gap-1">
                    <button
                        @click="hapus()"
                        x-show="items.length"
                        class="text-xs px-2 py-1 bg-red-600 text-white rounded"
                    >
                        Hapus
                    </button>
                    <button
                        @click="$dispatch('open-pengumuman-modal')"
                        class="text-xs px-2 py-1 bg-blue-600 text-white rounded">
                        Tambah
                    </button>
                </div>
            </div>

            <template x-if="current">
                <p class="text-sm mb-2 font-medium text-gray-600 dark:text-gray-300"
                x-text="current.judul">
                </p>
            </template>
            <div class="relative">
                <!-- PREV -->
                <button
                    @click="prev"
                    x-show="index > 0"
                    class="absolute left-2 top-1/2 -translate-y-1/2
                        bg-black/30 hover:bg-black/50 text-white
                        w-8 h-8 rounded-full z-10"
                >
                    ❮
                </button>

                <!-- NEXT -->
                <button
                    @click="next"
                    x-show="index < items.length - 1"
                    class="absolute right-2 top-1/2 -translate-y-1/2
                        bg-black/30 hover:bg-black/50 text-white
                        w-8 h-8 rounded-full z-10"
                >
                    ❯
                </button>

                <template x-if="current">
                    <iframe
                        :src="`/storage/${current.file_pdf}`"
                        class="w-full h-[calc(100vh-14rem)] border rounded"
                    ></iframe>
                </template>

                <template x-if="items.length === 0">
                    <p class="text-sm text-gray-400 italic">
                        Belum ada pengumuman
                    </p>
                </template>
            </div>

        </aside>
    </div>
    <div 
        x-data="{ open: false }"
        @open-pengumuman-modal.window="open = true"
        x-show="open"
        x-cloak
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Tambah Pengumuman</h2>

            <form method="POST" action="{{ route('pengumuman.store') }}" enctype="multipart/form-data">
                @csrf

                <input
                    type="text"
                    name="judul"
                    placeholder="Judul Pengumuman"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200"
                    required
                >

                <input
                    type="file"
                    name="file_pdf"
                    accept="application/pdf"
                    class="mt-1 block w-full text-sm text-gray-700
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700
                            dark:text-gray-200"
                    required
                >

                <input type="hidden" name="periode_id" value="{{ optional($periodeAktif)->id }}">

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open=false" class="text-sm px-3 py-1 border rounded">
                        Batal
                    </button>
                    <button type="submit" class="text-sm px-3 py-1 bg-blue-600 text-white rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>