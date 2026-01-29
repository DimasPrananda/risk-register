<thead>
    <tr>
        <th colspan="4"
            class="border border-gray-400 px-4 py-2 font-semibold bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
            Target Tingkat Risiko Residual (TR Residual)
        </th>
    </tr>
    <tr class="bg-gray-50 dark:bg-gray-800">
        <th class="border border-gray-400 dark:text-gray-200 px-4 py-2">Dampak</th>
        <th class="border border-gray-400 dark:text-gray-200 px-4 py-2">Probabilitas</th>
        <th class="border border-gray-400 dark:text-gray-200 px-4 py-2">Skala Risiko</th>
        <th class="border border-gray-400 dark:text-gray-200 px-4 py-2">Level Risiko</th>
    </tr>
</thead>
<tbody class="bg-white dark:bg-gray-900 dark:text-gray-200">
    <tr>
        <td class="border px-4 py-2">
            {{ $perlakuan->dampak ?? '-' }}
        </td>
        <td class="border px-4 py-2">
            {{ $perlakuan->probabilitas ?? '-' }}
        </td>
        <td class="border px-4 py-2 font-semibold">
            {{ $perlakuan->skala_risiko ?? '-' }}
        </td>
        <td class="border px-4 py-2 font-semibold">
            @if($perlakuan->level_risiko === 'High')
                <span class="block rounded-lg bg-red-600 text-white">High</span>
            @elseif($perlakuan->level_risiko === 'Moderate to High')
                <span class="block rounded-lg bg-orange-500 text-white">Moderate to High</span>
            @elseif($perlakuan->level_risiko === 'Moderate')
                <span class="block rounded-lg bg-yellow-500 text-white">Moderate</span>
            @elseif($perlakuan->level_risiko === 'Low to Moderate')
                <span class="block rounded-lg bg-green-500 text-white">Low to Moderate</span>
            @elseif($perlakuan->level_risiko === 'Low')
                <span class="block rounded-lg bg-green-700 text-white">Low</span>
            @else
                -
            @endif
        </td>
    </tr>
</tbody>