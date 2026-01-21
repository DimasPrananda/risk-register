<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Periode;
use App\Models\Sasaran;
use Illuminate\Http\Request;

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
        return view('admin.risk.sasaran', compact('periode', 'departemens'));
    }

    public function createSasaran(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'departemen_id' => 'required|exists:departemens,id',
            'nama_sasaran' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'risiko' => 'required|string|max:255',
            'dampak' => 'required|string|max:255',
        ]);

        Sasaran::create([
            'periode_id' => $request->periode_id,
            'departemen_id' => $request->departemen_id,
            'nama_sasaran' => $request->nama_sasaran,
            'target' => $request->target,
            'risiko' => $request->risiko,
            'dampak' => $request->dampak,
        ]);

        return redirect()->route('risk.sasaran', $request->periode_id)->with('success', 'Sasaran berhasil ditambahkan.');
    }

    public function updateSasaran(Request $request, Sasaran $sasaran)
    {
        $request->validate([
            'nama_sasaran' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'risiko' => 'required|string|max:255',
            'dampak' => 'required|string|max:255',
        ]);

        $sasaran->update([
            'nama_sasaran' => $request->nama_sasaran,
            'target' => $request->target,
            'risiko' => $request->risiko,
            'dampak' => $request->dampak,
        ]);

        return redirect()->route('risk.sasaran', $sasaran->periode_id)->with('success', 'Sasaran berhasil diperbarui.');
    }

    public function deleteSasaran(Sasaran $sasaran)
    {
        $periodeId = $sasaran->periode_id;
        $sasaran->delete();

        return redirect()->route('risk.sasaran', $periodeId)->with('success', 'Sasaran berhasil dihapus.');
    }

    public function detail(Sasaran $sasaran)
    {
        $sasaran->load('sebabRisikos.perlakuanRisikos');
        return view('risk.detail', compact('sasaran'));
    }
}