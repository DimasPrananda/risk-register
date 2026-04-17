<table border="1">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Sasaran</th>
            <th rowspan="2">Target</th>
            <th rowspan="2">Risiko</th>
            <th rowspan="2">Sebab Risiko</th>
            <th rowspan="2">Dampak Sebab</th>
            <th rowspan="2">Pengendalian</th>
            <th rowspan="2">Referensi Pengendalian</th>
            <th rowspan="2">Efektifitas Pengendalian</th>
            <th colspan="4">Tingkat Risiko</th>
            <th rowspan="2">Perlakuan</th>
            <th colspan="4">Target Tingkat Risiko Residual (TR Residual)</th>
        </tr>
        <tr>
            <th>Dampak</th>
            <th>Probabilitas</th>
            <th>Skala</th>
            <th>Level Risiko</th>
            <th>Dampak</th>
            <th>Probabilitas</th>
            <th>Skala</th>
            <th>Level Risiko</th>
        </tr>
    </thead>

    <tbody>
        @php 
            $row = 2;
            $no = 1;
         @endphp

        @foreach($sasaran->sebabRisikos as $sebab)

            @php
                $totalPerlakuan = max(1, $sebab->perlakuanRisikos->count());
                $startRow = $row;
            @endphp

            @foreach($sebab->perlakuanRisikos->count() ? $sebab->perlakuanRisikos : [null] as $perlakuan)
                <tr>
                    <td>
                        @if($loop->parent->first)
                            {{ $no++ }}.
                        @endif
                    </td>

                    <td>
                        @if($loop->parent->first)
                            {{ $sasaran->nama_sasaran }}
                        @endif
                    </td>
                    <td>
                        @if($loop->parent->first)
                            {{ $sasaran->target }}
                        @endif
                    </td>
                    <td>
                        @if($loop->parent->first)
                            {{ $sasaran->risiko }}
                        @endif
                    </td>

                    <td>{{ $sebab->nama_sebab }}</td>
                    <td>{{ $sebab->dampak_sebab }}</td>
                    <td>{{ $sebab->pengendalian_internal }}</td>
                    <td>{{ $sebab->referensi_pengendalian }}</td>
                    <td>{{ $sebab->efektifitas_pengendalian }}</td>
                    <td>{{ $sebab->dampak }}</td>
                    <td>{{ $sebab->probabilitas ?? '-' }}</td>
                    <td>{{ $sebab->skala_risiko ?? '-' }}</td>
                    <td>{{ $sebab->level_risiko ?? '-' }}</td>
                    <td>{{ $perlakuan->perlakuan_risiko ?? '-' }}</td>
                    <td>{{ $perlakuan->dampak ?? '-' }}</td>
                    <td>{{ $perlakuan->probabilitas ?? '-' }}</td>
                    <td>{{ $perlakuan->skala_risiko ?? '-' }}</td>
                    <td>{{ $perlakuan->level_risiko ?? '-' }}</td>
                </tr>

                @php $row++; @endphp
            @endforeach

            @php
                $endRow = $row - 1;
                $mergeData[] = [
                    'start' => $startRow,
                    'end' => $endRow
                ];
            @endphp

        @endforeach
    </tbody>
</table>