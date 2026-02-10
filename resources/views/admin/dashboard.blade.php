<x-app-layout>
    <div 
        x-data="{ activeDept: {{ $departemenAktif->id }} }"
        class="flex max-w-7xl ml-20 mx-auto sm:px-6 lg:px-8"
    >

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-white dark:bg-gray-900 p-4 space-y-2">
            @foreach($departemens as $dept)
                <button
                    @click="activeDept = {{ $dept->id }}"
                    class="w-full text-left px-4 py-2 rounded transition"
                    :class="activeDept === {{ $dept->id }}
                        ? 'inline-flex bg-gray-200 hover:bg-blue-100 font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest'
                        : 'inline-flex bg-gray-800 hover:bg-blue-100 font-semibold text-xs text-white dark:text-gray-600 uppercase tracking-widest'"
                >
                    {{ $dept->nama_departemen }}
                </button>
            @endforeach
        </aside>

        {{-- CONTENT --}}
        <main class="flex-1 p-6 space-y-6">

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

                {{-- PERIODE --}}
                <form method="GET">
                    <input type="hidden" name="departemen_id" value="{{ $departemenAktif->id }}">

                    <select
                        name="periode_id"
                        onchange="this.form.submit()"
                        class="w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white mb-4"
                    >
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}"
                                {{ $periodeAktif->id === $periode->id ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($periode->bulan_awal)->translatedFormat('F Y') }}
                                -
                                {{ \Carbon\Carbon::parse($periode->bulan_akhir)->translatedFormat('F Y') }}
                            </option>
                        @endforeach
                    </select>
                </form>

                {{-- RESIDUAL SUMMARY --}}
                @include('admin.dashboard.residual-summary')

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
                            {{ $sasaran->nama_sasaran }}
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
        </main>
    </div>
</x-app-layout>