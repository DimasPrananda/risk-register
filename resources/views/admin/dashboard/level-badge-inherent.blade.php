@if($risiko)
    @if($risiko->level_risiko === 'High')
        <span class="flex justify-center rounded-lg bg-red-600 text-white px-2 py-1 text-xs">
            {{ $risiko->level_risiko }}
        </span>
    @elseif($risiko->level_risiko === 'Moderate to High')
        <span class="flex justify-center rounded-lg bg-orange-500 text-white px-2 py-1 text-xs">
            {{ $risiko->level_risiko }}
        </span>
    @elseif($risiko->level_risiko === 'Moderate')
        <span class="flex justify-center rounded-lg bg-yellow-500 text-white px-2 py-1 text-xs">
            {{ $risiko->level_risiko }}
        </span>
    @elseif($risiko->level_risiko === 'Low to Moderate')
        <span class="flex justify-center rounded-lg bg-green-500 text-white px-2 py-1 text-xs">
            {{ $risiko->level_risiko }}
        </span>
    @elseif($risiko->level_risiko === 'Low')
        <span class="flex justify-center rounded-lg bg-green-700 text-white px-2 py-1 text-xs">
            {{ $risiko->level_risiko }}
        </span>
    @else
        <span class="text-gray-400">-</span>
    @endif
@else
    <span class="text-gray-400">-</span>
@endif