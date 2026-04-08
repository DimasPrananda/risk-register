<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function create()
    {
        $periodes = Periode::all();
        return view('admin.periode', compact('periodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan_awal' => 'required',
        ]);

        Periode::create([
            'bulan_awal' => $request->bulan_awal,
        ]);

        return redirect()->back()->with('success', 'Periode berhasil disimpan');
    }

    public function update(Request $request, Periode $periode)
    {
        $request->validate([
            'bulan_awal' => 'required',
        ]);

        $periode->update([
            'bulan_awal' => $request->bulan_awal,
        ]);

        return redirect()->back()->with('success', 'Periode berhasil diperbarui');
    }

    public function destroy(Periode $periode)
    {
        $periode->delete();
        return redirect()->back()->with('success', 'Periode berhasil dihapus');
    }
}
