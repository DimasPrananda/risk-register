<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SebabRisiko extends Model
{
    protected $fillable = ['sasaran_id', 'nama_sebab', 'kategori_id', 'pengendalian_internal', 'referensi_pengendalian', 'efektifitas_pengendalian', 'dampak', 'probabilitas'];

    public function sasaran()
    {
        return $this->belongsTo(Sasaran::class);
    }

    public function perlakuanRisikos()
    {
        return $this->hasMany(PerlakuanRisiko::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
