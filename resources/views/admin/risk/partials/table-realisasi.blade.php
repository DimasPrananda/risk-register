<thead class="bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
    <tr>
        <th class="border px-3 py-2 text-center">Keterangan</th>
        <th class="border px-3 py-2 text-center">Periode</th>
        <th class="border px-3 py-2 text-center">Target</th>
        <th class="border px-3 py-2 text-center">Realisasi</th>
        <th class="border px-3 py-2 text-center">Aksi</th>
    </tr>
</thead>
<tbody x-data="{ open: null }">

    {{-- OUTPUT --}}
    <tr>
        <td class="border px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-200 font-medium">Output</td>
        <td class="border px-3 py-2 dark:text-gray-200"> - </td>
        <td class="border px-3 py-2 dark:text-gray-200">{{ $perlakuan->output_target ?? '-' }}</td>
        <td class="border px-3 py-2 dark:text-gray-200">{{ $perlakuan->output_realisasi ?? '-' }}</td>
        <td class="border px-3 py-2 text-center">
            <button type="button"
                @click="open === 'output' ? open = null : open = 'output'"
                class="px-2 py-1 bg-blue-500 text-white rounded">
                {{ empty($perlakuan->output_realisasi) ? 'Tambah' : 'Edit' }}
            </button>

            @if(!empty($perlakuan->output_realisasi))
                <form action="{{ route('risk.perlakuan-risiko.realisasi', $perlakuan->id) }}"
                    method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="type" value="output">
                    <input type="hidden" name="delete" value="1">

                    <button type="submit"
                        class="px-2 py-1 bg-red-500 text-white rounded">
                        Hapus
                    </button>
                </form>
            @endif
        </td>
    </tr>

    <tr x-show="open === 'output'">
        <td colspan="5" class="border px-3 py-3">
            <form action="{{ route('risk.perlakuan-risiko.realisasi', $perlakuan->id) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="type" value="output">

                <input type="text" name="value"
                    placeholder="Isi realisasi output"
                    class="border rounded px-2 py-1 w-full">

                <button type="submit"
                    class="px-3 py-1 bg-blue-500 text-white rounded">
                    Simpan
                </button>
            </form>
        </td>
    </tr>


    {{-- TIMELINE --}}
    <tr>
        <td class="border px-3 py-2 font-medium bg-gray-100 dark:bg-gray-700 dark:text-gray-200">Timeline</td>
        <td class="border px-3 py-2 dark:text-gray-200">{{ $perlakuan->periode ?? '-' }}</td>
        <td class="border px-3 py-2 dark:text-gray-200">{{ $perlakuan->timeline_target ?? '-' }}</td>
        <td class="border px-3 py-2 dark:text-gray-200">{{ $perlakuan->timeline_realisasi ?? '-' }}</td>
        <td class="border px-3 py-2 text-center">
            <button type="button"
                @click="open === 'timeline' ? open = null : open = 'timeline'"
                class="px-2 py-1 bg-blue-500 text-white rounded">
                {{ empty($perlakuan->timeline_realisasi) ? 'Tambah' : 'Edit' }}
            </button>

            @if(!empty($perlakuan->timeline_realisasi))
                <form action="{{ route('risk.perlakuan-risiko.realisasi', $perlakuan->id) }}"
                    method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="type" value="timeline">
                    <input type="hidden" name="delete" value="1">

                    <button type="submit"
                        class="px-2 py-1 bg-red-500 text-white rounded">
                        Hapus
                    </button>
                </form>
            @endif
        </td>
    </tr>

    <tr x-show="open === 'timeline'">
        <td colspan="5" class="border px-3 py-3">
            <form action="{{ route('risk.perlakuan-risiko.realisasi', $perlakuan->id) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="type" value="timeline">

                <input type="text" name="value"
                    placeholder="Isi realisasi timeline"
                    class="border rounded px-2 py-1 w-full">

                <button type="submit"
                    class="px-3 py-1 bg-blue-500 text-white rounded">
                    Simpan
                </button>
            </form>
        </td>
    </tr>


    {{-- BIAYA --}}
    <tr>
        <td class="border px-3 py-2 font-medium bg-gray-100 dark:bg-gray-700 dark:text-gray-200">Biaya</td>
        <td class="border px-3 py-2 dark:text-gray-200"> - </td>
        <td class="border px-3 py-2 dark:text-gray-200">{{ $perlakuan->biaya_target 
            ? rtrim(rtrim(number_format($perlakuan->biaya_target / 1000000, 2), '0'), '.') . ' jt' 
            : '-' 
        }}</td>
        <td class="border px-3 py-2 dark:text-gray-200">{{ $perlakuan->biaya_realisasi 
            ? rtrim(rtrim(number_format($perlakuan->biaya_realisasi / 1000000, 2), '0'), '.') . ' jt' 
            : '-' 
        }}</td>
        <td class="border px-3 py-2 text-center">
            <button type="button"
                @click="open === 'biaya' ? open = null : open = 'biaya'"
                class="px-2 py-1 bg-blue-500 text-white rounded">
                {{ empty($perlakuan->biaya_realisasi) ? 'Tambah' : 'Edit' }}
            </button>

            @if(!empty($perlakuan->biaya_realisasi))
                <form action="{{ route('risk.perlakuan-risiko.realisasi', $perlakuan->id) }}"
                    method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="type" value="biaya">
                    <input type="hidden" name="delete" value="1">

                    <button type="submit"
                        class="px-2 py-1 bg-red-500 text-white rounded">
                        Hapus
                    </button>
                </form>
            @endif
        </td>
    </tr>

    <tr x-show="open === 'biaya'">
        <td colspan="5" class="border px-3 py-3">
            <form action="{{ route('risk.perlakuan-risiko.realisasi', $perlakuan->id) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="type" value="biaya">

                <input type="number" name="value"
                    placeholder="Isi realisasi biaya"
                    class="border rounded px-2 py-1 w-full">

                <button type="submit"
                    class="px-3 py-1 bg-blue-500 text-white rounded">
                    Simpan
                </button>
            </form>
        </td>
    </tr>

</tbody>