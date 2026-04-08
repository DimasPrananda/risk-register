<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'peristiwa_risiko_id' => 'required|exists:peristiwa_risikos,id',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        $totalBobot = Parameter::where('peristiwa_risiko_id', $request->peristiwa_risiko_id)
                        ->sum('bobot');

        if (($totalBobot + $request->bobot) > 100) {
            return back()->with('error', 'Total bobot parameter dalam risiko ini tidak boleh lebih dari 100%');
        }

        Parameter::create($request->all());

        return back()->with('success', 'Parameter berhasil ditambahkan');
    }

    public function update(Request $request, Parameter $parameter)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        $totalBobot = Parameter::where('peristiwa_risiko_id', $parameter->peristiwa_risiko_id)
                        ->where('id', '!=', $parameter->id)
                        ->sum('bobot');

        if (($totalBobot + $request->bobot) > 100) {
            return back()->with('error', 'Total bobot parameter dalam risiko ini tidak boleh lebih dari 100%');
        }

        $parameter->update($request->all());

        return back()->with('success', 'Parameter berhasil diperbarui');
    }

    public function destroy(Parameter $parameter)
    {
        $parameter->delete();
        return back()->with('success', 'Parameter berhasil dihapus');
    }
}
