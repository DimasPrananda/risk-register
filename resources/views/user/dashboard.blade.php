<x-app-layout>
    <div 
        x-data="{ activeDept: {{ $departemenAktif->id }} }"
        class="flex max-w-7xl ml-20 mx-auto"
    >
        <div class="flex w-full h-screen overflow-hidden">
            {{-- CONTENT --}}
            <main class="flex-1 mr-4">
                <section
                    x-data="{
                        cardPage: 1,
                        cardPerPage: 5,
                        totalCard: {{ $departemenAktif->sasarans->count() }},
                        get cardPages() {
                            return Math.ceil(this.totalCard / this.cardPerPage)
                        }
                    }"
                >

                    {{-- HEADER (PERIODE + SUMMARY) --}}
                    <div class="sticky top-5 z-20 bg-gray-100 dark:bg-gray-900">
                        {{-- PERIODE --}}
                        <form method="GET">
                            <select
                                name="periode_id"
                                onchange="this.form.submit()"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white mb-4"
                            >
                                @foreach($periodes as $periode)
                                    <option value="{{ $periode->id }}"
                                        {{ optional($periodeAktif)->id === $periode->id ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($periode->bulan_awal)->translatedFormat('F Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($periode->bulan_akhir)->translatedFormat('F Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        {{-- RESIDUAL SUMMARY (READ ONLY) --}}
                        @include('user.dashboard.residual-summary')
                    </div>

                    {{-- CONTENT --}}
                    <div class="py-6 space-y-6 overflow-y-auto max-h-[calc(100vh-16rem)]">
                        @forelse($departemenAktif->sasarans as $index => $sasaran)
                            <div
                                x-show="Math.ceil({{ $index + 1 }} / cardPerPage) === cardPage"
                                x-transition
                                class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-md shadow overflow-x-auto mb-4"
                            >
                                {{-- TITLE --}}
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
                            <p class="p-4 text-gray-500">
                                Sasaran belum ditentukan
                            </p>
                        @endforelse

                        {{-- CARD PAGINATION --}}
                        @include('admin.dashboard.card-pagination')
                    </div>
                </section>
            </main>
        </div>

        {{-- SIDEBAR PENGUMUMAN (READ ONLY) --}}
        <aside
            x-data="{
                index: 0,
                items: @js($pengumumen),

                get current() {
                    return this.items[this.index]
                },

                next() {
                    if (this.index < this.items.length - 1) this.index++
                },

                prev() {
                    if (this.index > 0) this.index--
                }
            }"
            class="w-80 sticky top-20 mt-5 h-[calc(100vh-5rem)]
                   p-4 dark:bg-gray-900
                   border-l dark:border-gray-700"
        >
            {{-- HEADER --}}
            <div class="flex items-center mb-3 gap-2">
                {{-- ICON --}}
                <img
                    src="{{ asset('icons/commercial-gray.svg') }}"
                    class="block w-6 h-6 dark:hidden"
                    alt="commercial light"
                >
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

                <span class="text-xs text-gray-400 ml-auto">
                    <span x-text="index + 1"></span>/<span x-text="items.length"></span>
                </span>
            </div>

            {{-- JUDUL --}}
            <template x-if="current">
                <p class="text-sm mb-2 font-medium text-gray-600 dark:text-gray-300"
                   x-text="current.judul">
                </p>
            </template>

            {{-- PDF --}}
            <div class="relative">
                {{-- PREV --}}
                <button
                    @click="prev"
                    x-show="index > 0"
                    class="absolute left-2 top-1/2 -translate-y-1/2
                           bg-black/30 hover:bg-black/50 text-white
                           w-8 h-8 rounded-full z-10"
                >
                    ❮
                </button>

                {{-- NEXT --}}
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
</x-app-layout>