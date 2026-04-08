<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaRisiko;
use Illuminate\Http\Request;

class PeristiwaRisikoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'taksonomi_id' => 'required|exists:taksonomis,id',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        $totalBobot = PeristiwaRisiko::where('taksonomi_id', $request->taksonomi_id)
                        ->sum('bobot');

        if (($totalBobot + $request->bobot) > 100) {
            return back()->with('error', 'Total bobot risiko dalam taksonomi ini tidak boleh lebih dari 100%');
        }

        PeristiwaRisiko::create($request->all());

        return back()->with('success', 'Peristiwa Risiko berhasil ditambahkan');
    }

    public function update(Request $request, PeristiwaRisiko $peristiwaRisiko)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        $totalBobot = PeristiwaRisiko::where('taksonomi_id', $peristiwaRisiko->taksonomi_id)
                        ->where('id', '!=', $peristiwaRisiko->id)
                        ->sum('bobot');

        if (($totalBobot + $request->bobot) > 100) {
            return back()->with('error', 'Total bobot risiko dalam taksonomi ini tidak boleh lebih dari 100%');
        }

        $peristiwaRisiko->update($request->all());

        return back()->with('success', 'Peristiwa Risiko berhasil diperbarui');
    }

    public function destroy(PeristiwaRisiko $peristiwaRisiko)
    {
        $peristiwaRisiko->delete();
        return back()->with('success', 'Peristiwa Risiko berhasil dihapus');
    }
}
