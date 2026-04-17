<table border="1">
    <tr>
        <td colspan="18" style="font-weight:bold; font-size:16px; text-align:center;">
            RISK REGISTER
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight:bold;">
            Departemen
        </td>
        <td colspan="2">
           : {{ $departemen->nama_departemen }}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight:bold;">
            Periode  
        </td>
        <td colspan="2">
           : {{ \Carbon\Carbon::parse($departemen->sasarans->first()->periode->bulan_awal)->translatedFormat('F Y') }} 
        </td>
    </tr>
    <tr></tr>
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
            $no = 1;
        @endphp

        @foreach($departemen->sasarans as $sasaran)

            @foreach($sasaran->sebabRisikos as $sebab)

                @php
                    $perlakuans = $sebab->perlakuanRisikos->count() 
                        ? $sebab->perlakuanRisikos 
                        : [null];
                @endphp

                @foreach($perlakuans as $perlakuan)
                    <tr>
                        {{-- NOMOR --}}
                        <td>
                            @if($loop->parent->first && $loop->first)
                                {{ $no++ }}.
                            @endif
                        </td>

                        {{-- SASARAN --}}
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

                        <td>{{ $sebab->nama_sebab    ?? '-' }}</td>
                        <td>{{ $sebab->dampak_sebab  ?? '-' }}</td>
                        <td>{{ $sebab->pengendalian_internal  ?? '-' }}</td>
                        <td>{{ $sebab->referensi_pengendalian  ?? '-' }}</td>
                        <td>{{ $sebab->efektifitas_pengendalian ?? '-' }}</td>

                        {{-- RISIKO AWAL --}}
                        <td>{{ $sebab->dampak }}</td>
                        <td>{{ $sebab->probabilitas ?? '-' }}</td>
                        <td>{{ $sebab->skala_risiko ?? '-' }}</td>
                        <td>{{ $sebab->level_risiko ?? '-' }}</td>

                        {{-- PERLAKUAN --}}
                        <td>{{ $perlakuan->perlakuan_risiko ?? '-' }}</td>

                        {{-- RESIDUAL --}}
                        <td>{{ $perlakuan->dampak ?? '-' }}</td>
                        <td>{{ $perlakuan->probabilitas ?? '-' }}</td>
                        <td>{{ $perlakuan->skala_risiko ?? '-' }}</td>
                        <td>{{ $perlakuan->level_risiko ?? '-' }}</td>
                    </tr>
                @endforeach

            @endforeach

        @endforeach
    </tbody>
</table>