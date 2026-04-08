<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PerlakuanRisiko;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;

class PerlakuanRisikoKomentarController extends Controller
{
    public function store(Request $request, $perlakuanRisikoId)
    {
        $request->validate([
            'isi' => 'required|string',
        ]);

        $perlakuanRisiko = PerlakuanRisiko::with([
            'sebabRisiko.sasaran.departemen'
        ])->findOrFail($perlakuanRisikoId);

        $sasaran = $perlakuanRisiko->sebabRisiko?->sasaran;

        if (!$sasaran) {
            return back()->withErrors('Sasaran tidak ditemukan');
        }

        $komentar = Komentar::create([
            'perlakuan_risiko_id' => $perlakuanRisikoId,
            'user_id' => auth()->id(),
            'isi' => $request->isi,
        ]);

        $pengomentar = auth()->user();

        if ($pengomentar->usertype === 'admin') {

            $users = User::where(function ($query) use ($sasaran) {
                    $query->where('id', $sasaran->user_id) // pemilik sasaran
                        ->orWhere('departemen_id', $sasaran->departemen_id); // satu departemen
                })
                ->where('id', '!=', auth()->id()) // ❌ admin sendiri
                ->get();

            foreach ($users as $user) {
                $user->notify(new CommentNotification($komentar, $sasaran));
            }
        }

        if ($pengomentar->usertype !== 'admin') {
            $admins = User::where('usertype', 'admin')->get();

            foreach ($admins as $admin) {
                $admin->notify(new CommentNotification($komentar, $sasaran));
            }
        }

        return back();
    }

    public function destroy(Komentar $komentar)
    {
        // Pastikan hanya pembuat komentar atau admin yang bisa menghapus
        if ($komentar->user_id === auth()->id() || auth()->user()->is_admin) {
            $komentar->delete();
            return back()->with('success', 'Komentar berhasil dihapus.');
        }

        return back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
    }
}
