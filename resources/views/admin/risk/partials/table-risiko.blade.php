<thead>
    <tr>
        <th colspan="4"
            class="border border-gray-400 px-4 py-2 font-semibold bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
            Target Tingkat Risiko Inherent (TR Inherent)
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
        <td class="border border-gray-400 px-4 py-2 text-center">
            {{ $item['dampak'] ?? '-' }}
        </td>

        <td class="border border-gray-400 px-4 py-2 text-center">
            {{ $item['probabilitas'] ?? '-' }}
        </td>

        <td class="border border-gray-400 px-4 py-2 text-center font-semibold">
            {{ $item['skala_risiko'] ?? '-' }}
        </td>

        <td class="border border-gray-400 px-4 py-2 text-center font-semibold">
            @if($item['level_risiko'] === 'High')
                <span class="flex flex-1 justify-center rounded-lg bg-red-600 text-white">{{ $item['level_risiko'] }}</span>
            @elseif($item['level_risiko'] === 'Moderate to High')
                <span class="flex flex-1 justify-center rounded-lg bg-orange-500 text-white">{{ $item['level_risiko'] }}</span>
            @elseif($item['level_risiko'] === 'Moderate')
                <span class="flex flex-1 justify-center rounded-lg bg-yellow-500 text-white">{{ $item['level_risiko'] }}</span>
            @elseif($item['level_risiko'] === 'Low to Moderate')
                <span class="flex flex-1 justify-center rounded-lg bg-green-500 text-white">{{ $item['level_risiko'] }}</span>
            @elseif($item['level_risiko'] === 'Low')
                <span class="flex flex-1 justify-center rounded-lg bg-green-700 text-white">{{ $item['level_risiko'] }}</span>
            @else
                -
            @endif
        </td>
    </tr>
</tbody>