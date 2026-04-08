<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'file_pdf' => 'required|mimes:pdf|max:2048',
            'periode_id' => 'nullable'
        ]);

        $file = $request->file('file_pdf');
        $path = $file->store('pengumuman', 'public');

        Pengumuman::create([
            'judul' => $request->judul,
            'file_pdf' => $path,
            'periode_id' => $request->periode_id
        ]);

        return back()->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if (Storage::disk('public')->exists($pengumuman->file_pdf)) {
            Storage::disk('public')->delete($pengumuman->file_pdf);
        }

        $pengumuman->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
