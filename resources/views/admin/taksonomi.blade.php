<x-app-layout>
    <div x-data="{
        addRisikoId: null,
        open: false,
        showModal: false,
        showRisikoModal: false,
        showParameterModal: false,
        taksonomi: {
            id: null,
            nama: '',
            bobot: ''
        },
        risiko: {
            id: null,
            taksonomi_id: null,
            nama: '',
            bobot: '' 
        },
        parameter: {
            id: null,
            peristiwa_risiko_id: null,
            nama: '',
            bobot: ''
        }
    }">
        {{-- Flash Message --}}
        <div class="p-1 ml-20 max-w-7xl mx-auto overflow-x-auto mb-4">

            @if(session('success'))
                <div 
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    x-transition
                    class="mb-4 p-3 rounded-lg 
                        bg-green-100 text-green-700 
                        dark:bg-green-900 dark:text-green-300"
                >
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div 
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    x-transition
                    class="mb-4 p-3 rounded-lg 
                        bg-red-100 text-red-700 
                        dark:bg-red-900 dark:text-red-300"
                >
                    {{ session('error') }}
                </div>
            @endif

        </div>
        

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Halaman Taksonomi') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Taksonomi</a>
        </x-slot>

        <div class="p-1 ml-20 max-w-7xl mx-auto overflow-x-auto mb-4">
            <div class=" text-right mb-5">

                <x-primary-button @click="
                    showModal = true;
                    taksonomi.id = null;
                    taksonomi.nama = '';
                    taksonomi.bobot = '';
                    ">
                    Tambah Taksonomi
                </x-primary-button>
            </div>

            @forelse($taksonomis as $taksonomi)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm mb-4 sm:rounded-lg p-6">

                    <div class="flex justify-between">
                        <div>
                            <h2 class="font-semibold text-gray-800 dark:text-gray-200 text-xl flex items-center gap-3">
                                {{ $taksonomi->nama }}

                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                    {{ $taksonomi->bobot }}%
                                </span>
                            </h2>
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
                                            taksonomi.id = {{ $taksonomi->id }};
                                            taksonomi.nama = '{{ $taksonomi->nama }}';
                                            taksonomi.bobot = '{{ $taksonomi->bobot }}';
                                        ">
                                        Edit
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('taksonomi.destroy', $taksonomi->id) }}">
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

                    <hr class="my-4">

                    {{-- LIST RISIKO --}}
                    @forelse($taksonomi->peristiwaRisikos as $risiko)
                        <div class="mt-4 p-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700">

                            <div class="flex justify-between">
                                <div>
                                    <h2 class="font-semibold text-gray-800 dark:text-gray-200 text-base flex items-center gap-3">
                                        {{ $risiko->nama }}

                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                            {{ $risiko->bobot }}%
                                        </span>
                                    </h2>
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
                                                    showRisikoModal = true;
                                                    risiko.id = {{ $risiko->id }};
                                                    risiko.nama = '{{ $risiko->nama }}';
                                                    risiko.bobot = '{{ $risiko->bobot }}';
                                                ">
                                                Edit
                                            </x-dropdown-link>
                                            <form method="POST" action="{{ route('peristiwa-risiko.destroy', $risiko->id) }}">
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

                            {{-- LIST PARAMETER --}}
                            <table class="w-full mt-2">
                                <thead class="bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th class=" p-2">No</th>
                                        <th class=" p-2">Nama</th>
                                        <th class=" p-2">Bobot</th>
                                        <th class=" p-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class=" dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                    @foreach($risiko->parameters as $parameter)
                                    <tr>
                                        <td class="border dark:border-gray-700 p-2 text-center">{{ $loop->iteration }}</td>
                                        <td class="border dark:border-gray-700 p-2">{{ $parameter->nama }}</td>
                                        <td class="border dark:border-gray-700 p-2 text-center">
                                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                                {{ $parameter->bobot }}%
                                            </span>
                                        </td>
                                        <td class="border dark:border-gray-700 p-2">
                                            <div class="flex justify-center gap-2">

                                                <!-- Edit Button -->
                                                <button
                                                    type="button"
                                                    @click.prevent="
                                                        showParameterModal = true;
                                                        parameter.id = {{ $parameter->id }};
                                                        parameter.peristiwa_risiko_id = {{ $parameter->peristiwa_risiko_id }};
                                                        parameter.nama = '{{ $parameter->nama }}';
                                                        parameter.bobot = '{{ $parameter->bobot }}';
                                                    "
                                                    class="flex items-center gap-1 px-3 py-1.5 text-sm 
                                                        bg-blue-600 hover:bg-blue-700 
                                                        text-white rounded-lg 
                                                        transition duration-200"
                                                >
                                                    <!-- Pencil Icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                                        class="h-4 w-4" 
                                                        fill="none" 
                                                        viewBox="0 0 24 24" 
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" 
                                                            stroke-linejoin="round" 
                                                            stroke-width="2" 
                                                            d="M11 5h2M12 3v2m6.364 2.636l-1.414-1.414M5 19l4-1 9-9-3-3-9 9-1 4z"/>
                                                    </svg>
                                                    Edit
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('parameter.destroy', $parameter->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                        class="flex items-center gap-1 px-3 py-1.5 text-sm 
                                                            bg-red-600 hover:bg-red-700 
                                                            text-white rounded-lg 
                                                            transition duration-200"
                                                    >
                                                        <!-- Trash Icon -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                                            class="h-4 w-4" 
                                                            fill="none" 
                                                            viewBox="0 0 24 24" 
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" 
                                                                stroke-linejoin="round" 
                                                                stroke-width="2" 
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m5-3v3"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class=" mt-4">
                                <x-primary-button @click="
                                    showParameterModal = true;
                                    parameter.id = null;
                                    parameter.peristiwa_risiko_id = {{ $risiko->id }};
                                    parameter.nama = '';
                                    parameter.bobot = '';
                                    ">
                                    Tambah Parameter
                                </x-primary-button>
                            </div>
                        </div>
                    @empty
                        <div class=" text-center text-gray-500">
                            Belum ada risiko untuk taksonomi ini.
                        </div>
                    @endforelse
                    <x-primary-button
                        class="mt-4"
                        @click="
                            showRisikoModal = true;
                            risiko.id = null;
                            risiko.taksonomi_id = {{ $taksonomi->id }};
                            risiko.nama = '';
                            risiko.bobot = '';
                        ">
                        Tambah Risiko
                    </x-primary-button>
                </div>
            @empty
                <div class=" text-center text-gray-500">
                    Belum ada data taksonomi.
                </div>
            @endforelse
        </div>
        {{-- =======================
        FORM TAMBAH TAKSONOMI
        ======================== --}}
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.self="showModal = false">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white" x-text="taksonomi.id ? 'Edit Taksonomi' : 'Tambah Taksonomi'"></h2>
                <form :action="taksonomi.id ? '/admin/taksonomi/' + taksonomi.id : '{{ route('taksonomi.store') }}'" method="POST">
                    @csrf
                    <template x-if="taksonomi.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                        <input type="text" name="nama" x-model="taksonomi.nama" class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bobot (%)</label>
                        <input type="number" step="0.01" name="bobot" x-model="taksonomi.bobot" class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="showModal = false" class="mr-2 px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- =======================
            MODAL PERISTIWA RISIKO
        ======================= --}}
        <div x-show="showRisikoModal"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @click.self="showRisikoModal = false">

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">

                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white"
                    x-text="risiko.id ? 'Edit Peristiwa Risiko' : 'Tambah Peristiwa Risiko'">
                </h2>

                <form :action="risiko.id 
                        ? '/admin/peristiwa-risiko/' + risiko.id 
                        : '{{ route('peristiwa-risiko.store') }}'"
                    method="POST">

                    @csrf

                    <!-- method PUT kalau edit -->
                    <template x-if="risiko.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <input type="hidden" name="taksonomi_id" :value="risiko.taksonomi_id">

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nama Risiko
                        </label>
                        <input type="text"
                            name="nama"
                            x-model="risiko.nama"
                            class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                            required>
                    </div>

                    <!-- Bobot -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Bobot (%)
                        </label>
                        <input type="number"
                            step="0.01"
                            name="bobot"
                            x-model="risiko.bobot"
                            class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                            required>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button"
                                @click="showRisikoModal = false"
                                class="px-4 py-2 bg-gray-300 rounded">
                            Batal
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
        {{-- =======================
            MODAL PARAMETER
        ======================= --}}
        <div x-show="showParameterModal"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @click.self="showParameterModal = false">

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">

                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white"
                    x-text="parameter.id ? 'Edit Parameter' : 'Tambah Parameter'">
                </h2>

                <form :action="parameter.id 
                        ? '/admin/parameter/' + parameter.id 
                        : '{{ route('parameter.store') }}'"
                    method="POST">

                    @csrf

                    <template x-if="parameter.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <input type="hidden"
                        name="peristiwa_risiko_id"
                        :value="parameter.peristiwa_risiko_id">

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nama Parameter
                        </label>
                        <input type="text"
                            name="nama"
                            x-model="parameter.nama"
                            class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                            required>
                    </div>

                    <!-- Bobot -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Bobot (%)
                        </label>
                        <input type="number"
                            step="0.01"
                            name="bobot"
                            x-model="parameter.bobot"
                            class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                            required>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button"
                                @click="showParameterModal = false"
                                class="px-4 py-2 bg-gray-300 rounded">
                            Batal
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>