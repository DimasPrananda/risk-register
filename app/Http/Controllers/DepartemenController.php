<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::all();
        return view('admin.departemen', compact('departemens'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255|unique:departemens,nama_departemen',
        ]);     

        Departemen::create([
            'nama_departemen' => $request->nama_departemen,
        ]);

        return redirect()->route('admin.departemen')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255|unique:departemens,nama_departemen,' . $departemen->id,
        ]);

        $departemen->update([
            'nama_departemen' => $request->nama_departemen,
        ]);

        return redirect()->route('admin.departemen')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Departemen $departemen)
    {
        $departemen->delete();

        return redirect()->route('admin.departemen')->with('success', 'Departemen berhasil dihapus.');
    }
}