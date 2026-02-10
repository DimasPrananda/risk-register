<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\Periode;
use App\Models\Sasaran;
use App\Models\SebabRisiko;

class DashboardController extends Controller
{
    public function admin(Request $request)
    {
        // 1️⃣ Semua departemen
        $departemens = Departemen::all();

        // 2️⃣ Semua periode (terbaru di atas)
        $periodes = Periode::orderBy('bulan_awal', 'desc')->get();

        // 3️⃣ Periode aktif
        $periodeAktif = $request->filled('periode_id')
            ? Periode::findOrFail($request->periode_id)
            : $periodes->first(); // ⬅️ AUTO periode terbaru

        // 4️⃣ Departemen aktif (tidak reset saat ganti periode)
        $departemenAktif = $request->filled('departemen_id')
            ? Departemen::findOrFail($request->departemen_id)
            : $departemens->first();

        // 5️⃣ Load relasi SESUAI periode aktif
        $departemenAktif->load([
            'sasarans' => function ($q) use ($periodeAktif) {
                $q->where('periode_id', $periodeAktif->id)
                ->where('is_published', 1) // HANYA yg published
                  ->with([
                      'sebabRisikos.kategori',
                      'sebabRisikos.perlakuanRisikos'
                  ]);
            }
        ]);

        // 6️⃣ Risk Matrix
        $riskMatrix = [
            1 => [1 => ['nilai'=>1,'level'=>'Low'], 2=>['nilai'=>5,'level'=>'Low'], 3=>['nilai'=>10,'level'=>'Low to Moderate'], 4=>['nilai'=>15,'level'=>'Moderate'], 5=>['nilai'=>20,'level'=>'High']],
            2 => [1 => ['nilai'=>2,'level'=>'Low'], 2=>['nilai'=>6,'level'=>'Low to Moderate'], 3=>['nilai'=>11,'level'=>'Low to Moderate'], 4=>['nilai'=>16,'level'=>'Moderate to High'], 5=>['nilai'=>21,'level'=>'High']],
            3 => [1 => ['nilai'=>3,'level'=>'Low'], 2=>['nilai'=>8,'level'=>'Low to Moderate'], 3=>['nilai'=>13,'level'=>'Moderate'], 4=>['nilai'=>18,'level'=>'Moderate to High'], 5=>['nilai'=>23,'level'=>'High']],
            4 => [1 => ['nilai'=>4,'level'=>'Low'], 2=>['nilai'=>9,'level'=>'Low to Moderate'], 3=>['nilai'=>14,'level'=>'Moderate'], 4=>['nilai'=>19,'level'=>'Moderate to High'], 5=>['nilai'=>24,'level'=>'High']],
            5 => [1 => ['nilai'=>7,'level'=>'Low to Moderate'], 2=>['nilai'=>12,'level'=>'Moderate'], 3=>['nilai'=>17,'level'=>'Moderate to High'], 4=>['nilai'=>22,'level'=>'High'], 5=>['nilai'=>25,'level'=>'High']],
        ];

        // 7️⃣ Hitung risk (SEMUA departemen untuk sidebar)
        foreach ($departemens as $dept) {
            $dept->load([
                'sasarans' => function ($q) use ($periodeAktif) {
                    $q->where('periode_id', $periodeAktif->id)
                        ->where('is_published', 1); // HANYA yg published
                },
                'sasarans.sebabRisikos.kategori',
                'sasarans.sebabRisikos.perlakuanRisikos'
            ]);

            foreach ($dept->sasarans as $sasaran) {
                foreach ($sasaran->sebabRisikos as $risiko) {

                    // INHERENT
                    $c = $risiko->dampak;
                    $l = $risiko->probabilitas;

                    if ($c && $l && isset($riskMatrix[$l][$c])) {
                        $risiko->skala_risiko = $riskMatrix[$l][$c]['nilai'];
                        $risiko->level_risiko = $riskMatrix[$l][$c]['level'];
                    } else {
                        $risiko->skala_risiko = null;
                        $risiko->level_risiko = '-';
                    }

                    // RESIDUAL
                    $residual = $risiko->perlakuanRisikos->last();

                    if ($residual) {
                        $cR = $residual->dampak;
                        $lR = $residual->probabilitas;

                        if ($cR && $lR && isset($riskMatrix[$lR][$cR])) {
                            $residual->skala_risiko = $riskMatrix[$lR][$cR]['nilai'];
                            $residual->level_risiko = $riskMatrix[$lR][$cR]['level'];
                        } else {
                            $residual->skala_risiko = null;
                            $residual->level_risiko = '-';
                        }
                    }
                }
            }
        }

        $residualSummary = []; // per departemen

        foreach ($departemens as $dept) {

            $residualSummary[$dept->id] = [
                'High' => 0,
                'Moderate to High' => 0,
                'Moderate' => 0,
                'Low to Moderate' => 0,
                'Low' => 0,
            ];

            foreach ($dept->sasarans as $sasaran) {
                foreach ($sasaran->sebabRisikos as $risiko) {
                    $residual = $risiko->perlakuanRisikos->last();

                    if ($residual && isset($residualSummary[$dept->id][$residual->level_risiko])) {
                        $residualSummary[$dept->id][$residual->level_risiko]++;
                    }
                }
            }
        }

        // 8️⃣ Kirim ke view
        return view('admin.dashboard', compact(
            'departemens',
            'departemenAktif',
            'periodes',
            'periodeAktif',
            'residualSummary'
        ));
    }
}