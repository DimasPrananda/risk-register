<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Halaman Pilih Periode') }}
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Pilih Periode</a>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ml-20">
        <form method="POST" action="{{ route('risk.submit-periode') }}">
            @csrf

            <label class="block text-gray-700 dark:text-gray-200">Pilih Periode</label>
            <select name="periode_id" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-gray-200">
                @foreach($periodes as $periode)
                <option value="{{ $periode->id }}">
                    {{ \Carbon\Carbon::parse($periode->bulan_awal)->translatedFormat('F Y') }}
                    -
                    {{ \Carbon\Carbon::parse($periode->bulan_akhir)->translatedFormat('F Y') }}
                </option>
                @endforeach
            </select>

            <x-primary-button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                Submit
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
