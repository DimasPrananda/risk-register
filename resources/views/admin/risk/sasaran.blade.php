<x-app-layout>
    <div 
    x-data="{
        showModal:false,
        risikos:[],
        parameters:[],
        sasaran:{
            id:null,
            nama_sasaran:'',
            target:'',
            risiko:'',
            departemen_id:'',
            taksonomi_id:'',
            peristiwa_risiko_id:'',
            parameter_id:''
        },

        resetForm(){
            this.sasaran={
                id:null,
                nama_sasaran:'',
                target:'',
                risiko:'',
                departemen_id:'',
                taksonomi_id:'',
                peristiwa_risiko_id:'',
                parameter_id:''
            }
        },

        async getRisiko(){
            this.risikos=[]
            this.parameters=[]
            this.sasaran.peristiwa_risiko_id=''
            this.sasaran.parameter_id=''

            if(this.sasaran.taksonomi_id){
                let res = await fetch(`/get-risiko/${this.sasaran.taksonomi_id}`)
                this.risikos = await res.json()
            }
        },

        async getParameter(){
            this.parameters=[]
            this.sasaran.parameter_id=''

            if(this.sasaran.peristiwa_risiko_id){
                let res = await fetch(`/get-parameter/${this.sasaran.peristiwa_risiko_id}`)
                this.parameters = await res.json()
            }
        }
    }"
    >
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
            </span>
        </x-slot>


        <div class="p-1 ml-20 max-w-7xl mx-auto overflow-x-auto mb-4">
            <div class=" text-right mb-5">

                <x-primary-button @click="showModal = true; resetForm()">
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

                                <div class=" ml-4 w-full overflow-x-auto">
                                    @if($departemen->sasarans->count())
                                        <div class="flex gap-4 snap-x snap-mandatory pb-4">
                                            @foreach($departemen->sasarans as $sasaran)
                                                <div class="flex-shrink-0 w-80
                                                            flex flex-col border rounded p-3
                                                            bg-gray-50 dark:bg-gray-700
                                                            snap-start">
                                                    <div class="flex justify-between items-start font-semibold text-xl gap-2">
                                                        <div class="flex-1 min-w-0">
                                                            <p class="truncate">
                                                                {{ $sasaran->nama_sasaran }}
                                                            </p>
                                                            @if($sasaran->is_published)
                                                                <span class="inline-block mt-1 text-xs font-semibold
                                                                    text-green-700 bg-green-100
                                                                    px-2 py-0.5 rounded mb-2">
                                                                    ✅ Published
                                                                </span>
                                                            @else
                                                                <span class="inline-block mt-1 text-xs font-semibold
                                                                    text-yellow-700 bg-yellow-100
                                                                    px-2 py-0.5 rounded mb-2">
                                                                    ⏳ Belum Publish
                                                                </span>
                                                            @endif
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
                                                                @click.prevent='
                                                                showModal = true;
                                                                sasaran = {
                                                                    id: {{ $sasaran->id }},
                                                                    nama_sasaran: @json($sasaran->nama_sasaran),
                                                                    target: @json($sasaran->target),
                                                                    risiko: @json($sasaran->risiko),
                                                                    departemen_id: {{ $sasaran->departemen_id }},
                                                                    taksonomi_id: {{ $sasaran->taksonomi_id }},
                                                                    peristiwa_risiko_id: {{ $sasaran->peristiwa_risiko_id }},
                                                                    parameter_id: {{ $sasaran->parameter_id }}
                                                                }'
                                                                >
                                                                Edit
                                                                </x-dropdown-link>
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
                                                    </div>
                                                    <div class=" mt-auto flex items-end">
                                                        <x-secondary-button onclick="window.location='{{ route('risk.detail', $sasaran) }}'"
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
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-11/12 md:w-1/3 h-[85vh] flex flex-col">
                    <div class=" p-6">
                        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white" x-text="sasaran.id ? 'Edit Sasaran' : 'Tambah Sasaran'"></h2>
                    </div>

                    <div class=" flex-1 overflow-y-auto p-6">
                        <form :action="sasaran.id 
                            ? '{{ url('/admin/risk-register/sasaran') }}/' + sasaran.id 
                            : '{{ route('risk.sasaran.store') }}'"
                        method="POST">

                        @csrf

                        <template x-if="sasaran.id">
                            <input type="hidden" name="_method" value="PUT">
                        </template>
                            <div class="mb-4">
                                <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Nama Sasaran
                                </label>
                                <input type="text"
                                        name="nama_sasaran"
                                        x-model="sasaran.nama_sasaran"
                                        class="mt-1 block w-full rounded-md border-gray-300
                                                dark:bg-gray-700 dark:text-gray-200"
                                        required>
                            </div>

                            <div class="mb-4 ">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Target
                                </label>
                                <input type="text"
                                        name="target"
                                        x-model="sasaran.target"
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
                                        x-model="sasaran.risiko"
                                        class="mt-1 block w-full rounded-md border-gray-300
                                                dark:bg-gray-700 dark:text-gray-200"
                                        required>
                            </div>

                            {{-- ================= RISIKO CORPORATE ================= --}}
                            <div class="mb-6 border rounded-lg p-4 
                                        bg-gray-50 dark:bg-gray-900 
                                        border-gray-200 dark:border-gray-700">

                                <h3 class="text-md font-semibold mb-4 
                                        text-gray-800 dark:text-gray-200">
                                    Risiko Corporate
                                </h3>

                                {{-- TAKSONOMI --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Taksonomi
                                    </label>
                                    <select name="taksonomi_id"
                                            x-model="sasaran.taksonomi_id"
                                            @change="getRisiko()"
                                            class="mt-1 block w-full rounded-md border-gray-300
                                                dark:bg-gray-700 dark:text-gray-200"
                                            required>
                                        <option value="">-- Pilih Taksonomi --</option>
                                        @foreach($taksonomis as $taksonomi)
                                            <option value="{{ $taksonomi->id }}">
                                                {{ $taksonomi->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- RISIKO --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Peristiwa Risiko
                                    </label>
                                    <select name="peristiwa_risiko_id"
                                            x-model="sasaran.peristiwa_risiko_id"
                                            @change="getParameter()"
                                            class="mt-1 block w-full rounded-md border-gray-300
                                                dark:bg-gray-700 dark:text-gray-200"
                                            required>
                                        <option value="">-- Pilih Risiko --</option>
                                        <template x-for="item in risikos" :key="item.id">
                                            <option :value="item.id" x-text="item.nama"></option>
                                        </template>
                                    </select>
                                </div>

                                {{-- PARAMETER --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Parameter
                                    </label>
                                    <select name="parameter_id"
                                            x-model="sasaran.parameter_id"
                                            class="mt-1 block w-full rounded-md border-gray-300
                                                dark:bg-gray-700 dark:text-gray-200"
                                            required>
                                        <option value="">-- Pilih Parameter --</option>
                                        <template x-for="item in parameters" :key="item.id">
                                            <option :value="item.id" x-text="item.nama"></option>
                                        </template>
                                    </select>
                                </div>

                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Departemen
                                </label>
                                <select name="departemen_id"
                                        x-model="sasaran.departemen_id"
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
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded" x-text="sasaran.id ? 'Update Sasaran' : 'Simpan Sasaran'">
                                    
                                </button>
                            </div>
                        </form>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
