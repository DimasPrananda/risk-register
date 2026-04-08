<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Kategori;
use App\Models\Parameter;
use App\Models\PerlakuanRisiko;
use App\Models\Periode;
use App\Models\PeristiwaRisiko;
use App\Models\Sasaran;
use App\Models\SebabRisiko;
use App\Models\Taksonomi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiskRegisterController extends Controller
{
    public function pilihPeriode()
    {
        $periodes = Periode::all();
        return view('admin.risk.periode', compact('periodes'));
    }

    public function submitPeriode(Request $request)
    {
        return redirect()->route('risk.sasaran', $request->periode_id);
    }

    public function sasaran(Periode $periode)
    {
        $departemens = Departemen::with(['sasarans' => function ($q) use ($periode) {
            $q->where('periode_id', $periode->id);
        }])->get();

        $taksonomis = Taksonomi::all();

        return view('admin.risk.sasaran', compact('periode', 'departemens', 'taksonomis'));
    }

    public function createSasaran(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'departemen_id' => 'required|exists:departemens,id',
            'nama_sasaran' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'risiko' => 'required|string|max:255',
            'taksonomi_id' => 'required|exists:taksonomis,id',
            'peristiwa_risiko_id' => 'required|exists:peristiwa_risikos,id',
            'parameter_id' => 'required|exists:parameters,id',
        ]);

        Sasaran::create([
            'periode_id' => $request->periode_id,
            'departemen_id' => $request->departemen_id,
            'nama_sasaran' => $request->nama_sasaran,
            'target' => $request->target,
            'risiko' => $request->risiko,
            'taksonomi_id' => $request->taksonomi_id,
            'peristiwa_risiko_id' => $request->peristiwa_risiko_id,
            'parameter_id' => $request->parameter_id,
        ]);

        return redirect()->route('risk.sasaran', $request->periode_id)->with('success', 'Sasaran berhasil ditambahkan.');
    }

    public function updateSasaran(Request $request, Sasaran $sasaran)
    {
        $request->validate([
            'nama_sasaran' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'risiko' => 'required|string|max:255',
            'departemen_id' => 'required|exists:departemens,id',
            'taksonomi_id' => 'required|exists:taksonomis,id',
            'peristiwa_risiko_id' => 'required|exists:peristiwa_risikos,id',
            'parameter_id' => 'required|exists:parameters,id',
        ]);

        $sasaran->update([
            'nama_sasaran' => $request->nama_sasaran,
            'target' => $request->target,
            'risiko' => $request->risiko,
            'departemen_id' => $request->departemen_id,
            'taksonomi_id' => $request->taksonomi_id,
            'peristiwa_risiko_id' => $request->peristiwa_risiko_id,
            'parameter_id' => $request->parameter_id,
            'is_published' => 1, // reset publish saat update
        ]);

        return redirect()->route('risk.sasaran', $sasaran->periode_id)->with('success', 'Sasaran berhasil diperbarui.');
    }

    public function deleteSasaran(Sasaran $sasaran)
    {
        $periodeId = $sasaran->periode_id;
        $sasaran->delete();

        return redirect()->route('risk.sasaran', $periodeId)->with('success', 'Sasaran berhasil dihapus.');
    }

    public function getRisiko($taksonomi_id)
    {
        return PeristiwaRisiko::where('taksonomi_id', $taksonomi_id)->get();
    }

    public function getParameter($risiko_id)
    {
        return Parameter::where('peristiwa_risiko_id', $risiko_id)->get();
    }

    public function publish($id)
    {
        $sasaran = Sasaran::findOrFail($id);

        $sasaran->update([
            'is_published' => true,
            'published_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Sasaran berhasil dipublish');
    }

    public function unpublish($id)
    {
        $sasaran = Sasaran::findOrFail($id);

        $sasaran->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return back()->with('success', 'Sasaran berhasil di-unpublish');
    }

    public function detail(Sasaran $sasaran)
    {
        // 1️⃣ AMBIL DATA DASAR
        $kategoris = Kategori::all();
        $sasaran->load('sebabRisikos.perlakuanRisikos');

        // 2️⃣ POIN 1: RISK MATRIX (DITARUH DI SINI)
        $riskMatrix = [
            1 => [
                1 => ['nilai' => 1,  'level' => 'Low'],
                2 => ['nilai' => 5,  'level' => 'Low'],
                3 => ['nilai' => 10, 'level' => 'Low to Moderate'],
                4 => ['nilai' => 15, 'level' => 'Moderate'],
                5 => ['nilai' => 20, 'level' => 'High'],
            ],
            2 => [
                1 => ['nilai' => 2,  'level' => 'Low'],
                2 => ['nilai' => 6,  'level' => 'Low to Moderate'],
                3 => ['nilai' => 11, 'level' => 'Low to Moderate'],
                4 => ['nilai' => 16, 'level' => 'Moderate to High'],
                5 => ['nilai' => 21, 'level' => 'High'],
            ],
            3 => [
                1 => ['nilai' => 3,  'level' => 'Low'],
                2 => ['nilai' => 8,  'level' => 'Low to Moderate'],
                3 => ['nilai' => 13, 'level' => 'Moderate'],
                4 => ['nilai' => 18, 'level' => 'Moderate to High'],
                5 => ['nilai' => 23, 'level' => 'High'],
            ],
            4 => [
                1 => ['nilai' => 4,  'level' => 'Low'],
                2 => ['nilai' => 9,  'level' => 'Low to Moderate'],
                3 => ['nilai' => 14, 'level' => 'Moderate'],
                4 => ['nilai' => 19, 'level' => 'Moderate to High'],
                5 => ['nilai' => 24, 'level' => 'High'],
            ],
            5 => [
                1 => ['nilai' => 7,  'level' => 'Low to Moderate'],
                2 => ['nilai' => 12, 'level' => 'Moderate'],
                3 => ['nilai' => 17, 'level' => 'Moderate to High'],
                4 => ['nilai' => 22, 'level' => 'High'],
                5 => ['nilai' => 25, 'level' => 'High'],
            ],
        ];

        // 3️⃣ HITUNG SKALA & LEVEL RISIKO
        $sebabRisikos = $sasaran->sebabRisikos->each(function ($item) use ($riskMatrix) {
            $c = $item->dampak;
            $l = $item->probabilitas;

            if ($c && $l && isset($riskMatrix[$l][$c])) {
                $item->skala_risiko = $riskMatrix[$l][$c]['nilai'];
                $item->level_risiko = $riskMatrix[$l][$c]['level'];
            } else {
                $item->skala_risiko = null;
                $item->level_risiko = '-';
            }
            
            $item->perlakuanRisikos->each(function ($perlakuan) use ($riskMatrix) {

                $c2 = $perlakuan->dampak;
                $l2 = $perlakuan->probabilitas;

                if ($c2 && $l2 && isset($riskMatrix[$l2][$c2])) {
                    $perlakuan->skala_risiko = $riskMatrix[$l2][$c2]['nilai'];
                    $perlakuan->level_risiko = $riskMatrix[$l2][$c2]['level'];
                } else {
                    $perlakuan->skala_risiko = null;
                    $perlakuan->level_risiko = '-';
                }
            });
        });

        // 4️⃣ KIRIM KE VIEW
        return view('admin.risk.detail', [
            'periode' => $sasaran->periode,
            'kategoris' => $kategoris,
            'sasaran' => $sasaran,
            'sebabRisikos' => $sebabRisikos,
        ]);
    }

    public function createSebabRisiko(Request $request, Sasaran $sasaran)
    {
        $request->validate([
            'nama_sebab' => 'required|string',
            'pengendalian_internal' => 'required|string',
            'referensi_pengendalian' => 'required|string|max:255',
            'efektifitas_pengendalian' => 'required|string|max:255',
            'dampak' => 'nullable|integer',
            'dampak_sebab' => 'nullable|string',
            'probabilitas' => 'nullable|integer',
        ]);

        $sasaran->sebabRisikos()->create([
            'nama_sebab' => $request->nama_sebab,
            'pengendalian_internal' => $request->pengendalian_internal,
            'referensi_pengendalian' => $request->referensi_pengendalian,
            'efektifitas_pengendalian' => $request->efektifitas_pengendalian,
            'dampak' => $request->dampak,
            'dampak_sebab' => $request->dampak_sebab,
            'probabilitas' => $request->probabilitas,
        ]);

        return redirect()->route('risk.detail', $sasaran->id)->with('success', 'Sebab risiko berhasil ditambahkan.');
    }

    public function updateSebabRisiko(Request $request, Sasaran $sasaran)
    {
        $request->validate([
            'sebab_risiko_id' => 'required|exists:sebab_risikos,id',
            'nama_sebab' => 'required|string',
            'pengendalian_internal' => 'required|string',
            'referensi_pengendalian' => 'required|string|max:255',
            'efektifitas_pengendalian' => 'required|string|max:255',
            'dampak' => 'nullable|integer',
            'dampak_sebab' => 'nullable|string',
            'probabilitas' => 'nullable|integer',
        ]);

        $sebabRisiko = $sasaran->sebabRisikos()->findOrFail($request->sebab_risiko_id);
        $sebabRisiko->update([
            'nama_sebab' => $request->nama_sebab,
            'pengendalian_internal' => $request->pengendalian_internal,
            'referensi_pengendalian' => $request->referensi_pengendalian,
            'efektifitas_pengendalian' => $request->efektifitas_pengendalian,
            'dampak' => $request->dampak,
            'dampak_sebab' => $request->dampak_sebab,
            'probabilitas' => $request->probabilitas,
        ]);

        return redirect()->route('risk.detail', $sasaran->id)->with('success', 'Sebab risiko berhasil diperbarui.');
    }

    public function deleteSebabRisiko(Request $request, Sasaran $sasaran)
    {
        $request->validate([
            'sebab_risiko_id' => 'required|exists:sebab_risikos,id',
        ]);

        $sebabRisiko = $sasaran->sebabRisikos()->findOrFail($request->sebab_risiko_id);
        $sebabRisiko->delete();

        return redirect()->route('risk.detail', $sasaran->id)->with('success', 'Sebab risiko berhasil dihapus.');
    }  
    
    public function createPerlakuanRisiko(Request $request, SebabRisiko $sebab_risiko)
    {
        $request->validate([
            'perlakuan_risiko' => 'required|string',
            'dampak' => 'nullable|integer',
            'probabilitas' => 'nullable|integer',
            'tanggal_pelaksanaan' => 'required|string',

            'output_target' => 'nullable|string',
            'output_realisasi' => 'nullable|string',

            'timeline_periode' => 'nullable|string',
            'timeline_target' => 'nullable|string',
            'timeline_realisasi' => 'nullable|string',

            'biaya_target' => 'nullable|numeric',
            'biaya_realisasi' => 'nullable|numeric',

            'biaya_mitigasi' => 'nullable|numeric',
            'periode' => 'required|in:Bulanan,Triwulan,Semester,Tahunan',
            'dokumen_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'komentar' => 'nullable|string',
        ]);
        
        $path = null;

        if ($request->hasFile('dokumen_pdf')) {
            $path = $request->file('dokumen_pdf')
                ->store('dokumen_risiko', 'public');
        }

        $sebab_risiko->perlakuanRisikos()->create([
            'perlakuan_risiko' => $request->perlakuan_risiko,
            'dampak' => $request->dampak,
            'probabilitas' => $request->probabilitas,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

            'output_target' => $request->output_target,
            'output_realisasi' => $request->output_realisasi,

            'timeline_periode' => $request->timeline_periode,
            'timeline_target' => $request->timeline_target,
            'timeline_realisasi' => $request->timeline_realisasi,

            'biaya_target' => $request->biaya_target,
            'biaya_realisasi' => $request->biaya_realisasi,

            'biaya_mitigasi' => $request->biaya_mitigasi,
            'periode' => $request->periode,
            'dokumen_pdf' => $path,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('risk.detail', $sebab_risiko->sasaran_id)->with('success', 'Perlakuan risiko berhasil ditambahkan.');
    }

    public function updatePerlakuanRisiko(Request $request, SebabRisiko $sebab_risiko)
    {
        $request->validate([
            'perlakuan_risiko_id' => 'required|exists:perlakuan_risikos,id',
            'perlakuan_risiko' => 'required|string',
            'dampak' => 'nullable|integer',
            'probabilitas' => 'nullable|integer',
            'tanggal_pelaksanaan' => 'required|string',
            
            'output_target' => 'nullable|string',
            'output_realisasi' => 'nullable|string',

            'timeline_periode' => 'nullable|string',
            'timeline_target' => 'nullable|string',
            'timeline_realisasi' => 'nullable|string',

            'biaya_target' => 'nullable|numeric',
            'biaya_realisasi' => 'nullable|numeric',

            'biaya_mitigasi' => 'nullable|numeric',
            'periode' => 'required|in:Bulanan,Triwulan,Semester,Tahunan',
            'dokumen_pdf' => 'nullable|file|mimes:pdf|max:5120'
        ]);

        $perlakuanRisiko = $sebab_risiko
            ->perlakuanRisikos()
            ->findOrFail($request->perlakuan_risiko_id);

        $data = [
            'perlakuan_risiko' => $request->perlakuan_risiko,
            'dampak' => $request->dampak,
            'probabilitas' => $request->probabilitas,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

            'output_target' => $request->output_target,
            'output_realisasi' => $request->output_realisasi,

            'timeline_periode' => $request->timeline_periode,
            'timeline_target' => $request->timeline_target,
            'timeline_realisasi' => $request->timeline_realisasi,

            'biaya_target' => $request->biaya_target,
            'biaya_realisasi' => $request->biaya_realisasi,
            
            'biaya_mitigasi' => $request->biaya_mitigasi,
            'periode' => $request->periode,
        ];

        // Jika upload file baru
        if ($request->hasFile('dokumen_pdf')) {

            // hapus file lama jika ada
            if ($perlakuanRisiko->dokumen_pdf &&
                Storage::disk('public')->exists($perlakuanRisiko->dokumen_pdf)) {
                Storage::disk('public')->delete($perlakuanRisiko->dokumen_pdf);
            }

            // simpan file baru
            $data['dokumen_pdf'] = $request->file('dokumen_pdf')
                                            ->store('perlakuan_risiko', 'public');
        }

        $perlakuanRisiko->update($data);

        return redirect()
            ->route('risk.detail', $sebab_risiko->sasaran_id)
            ->with('success', 'Perlakuan risiko berhasil diperbarui.');
    }

    public function deletePerlakuanRisiko(Request $request, SebabRisiko $sebab_risiko)
    {
        $request->validate([
            'perlakuan_risiko_id' => 'required|exists:perlakuan_risikos,id',
        ]);

        $perlakuanRisiko = $sebab_risiko->perlakuanRisikos()->findOrFail($request->perlakuan_risiko_id);
        $sasaranId = $sebab_risiko->sasaran_id;
        $perlakuanRisiko->delete();

        return redirect()->route('risk.detail', $sasaranId)->with('success', 'Perlakuan risiko berhasil dihapus.');
    }
    
    public function updateRealisasi(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:output,timeline,biaya',
            'value' => 'nullable'
        ]);

        $data = PerlakuanRisiko::findOrFail($id);

        if ($request->type == 'output') {
            $data->output_realisasi = $request->value;
        }

        if ($request->type == 'timeline') {
            $data->timeline_realisasi = $request->value;
        }

        if ($request->type == 'biaya') {
            $data->biaya_realisasi = $request->value;
        }

        $data->save();

        return back()->with('success', 'Realisasi berhasil disimpan');
    }
}