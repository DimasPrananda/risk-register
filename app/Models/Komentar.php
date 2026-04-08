<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $fillable = [
        'perlakuan_risiko_id',
        'user_id',
        'isi',
    ];

    public function perlakuanRisiko()
    {
        return $this->belongsTo(PerlakuanRisiko::class, 'perlakuabn_risiko_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
