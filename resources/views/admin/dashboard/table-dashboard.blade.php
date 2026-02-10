<table class="w-full border-t border-b text-sm text-center border-gray-200 dark:border-gray-700">
    <thead class="bg-gray-100 dark:bg-gray-800 dark:text-gray-200">
        <tr>
            <th rowspan="2" class="px-2 py-1">No</th>
            <th rowspan="2" class="px-2 py-1">Kategori Risiko</th>
            <th rowspan="2" class="px-2 py-1 text-left">Sebab Risiko</th>
            <th colspan="4" class="px-2 py-1">Inherent Risk</th>
            <th colspan="4" class="px-2 py-1">Residual Risk</th>
        </tr>
        <tr>
            <th>C</th>
            <th>L</th>
            <th>TR</th>
            <th>Level</th>
            <th>C</th>
            <th>L</th>
            <th>TR</th>
            <th>Level</th>
        </tr>
    </thead>

    <tbody class="dark:border-gray-700">
        @foreach($sasaran->sebabRisikos as $i => $risiko)
        @php
            $residual = $risiko->perlakuanRisikos->last();
        @endphp

        <tr
            x-show="Math.ceil({{ $i + 1 }} / perPage) === page"
            x-transition
            class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 dark:text-gray-200"
            @click="window.location.href = '{{ route('risk.detail', $sasaran->id) }}'"
        >
            <td>{{ $i + 1 }}</td>
            <td>{{ $risiko->kategori->nama_kategori ?? '-' }}</td>
            <td class="text-left">{{ $risiko->nama_sebab }}</td>
            <td>{{ $risiko->dampak }}</td>
            <td>{{ $risiko->probabilitas }}</td>
            <td>{{ $risiko->skala_risiko }}</td>
            <td class="px-2 py-1">
                @include('admin.dashboard.level-badge-inherent', ['level' => $risiko->level_risiko])
        </td>
            <td>{{ $residual->dampak ?? '-' }}</td>
            <td>{{ $residual->probabilitas ?? '-' }}</td>
            <td>{{ $residual->skala_risiko ?? '-' }}</td>
            <td class="px-2 py-1">
                @include('admin.dashboard.level-badge-residual', ['level' => $residual->level_risiko])
            </td>
        </tr>
        @endforeach
    </tbody>
</table>