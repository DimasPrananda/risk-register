<?php

namespace App\Http\Controllers;

use App\Models\Taksonomi;
use Illuminate\Http\Request;

class TaksonomiController extends Controller
{
    public function index()
    {
        $taksonomis = Taksonomi::with('peristiwaRisikos.parameters')->get();
        return view('admin.taksonomi', compact('taksonomis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        $totalBobot = Taksonomi::sum('bobot');

        if (($totalBobot + $request->bobot) > 100) {
            return back()->with('error', 'Total bobot taksonomi tidak boleh lebih dari 100%');
        }

        Taksonomi::create($request->all());

        return back()->with('success', 'Taksonomi berhasil ditambahkan');
    }

    public function update(Request $request, Taksonomi $taksonomi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        $totalBobot = Taksonomi::where('id', '!=', $taksonomi->id)
                        ->sum('bobot');

        if (($totalBobot + $request->bobot) > 100) {
            return back()->with('error', 'Total bobot taksonomi tidak boleh lebih dari 100%');
        }

        $taksonomi->update($request->all());

        return back()->with('success', 'Taksonomi berhasil diperbarui');
    }

    public function destroy(Taksonomi $taksonomi)
    {
        $taksonomi->delete();
        return back()->with('success', 'Taksonomi berhasil dihapus');
    }
}
