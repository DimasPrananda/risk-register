<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SebabRisiko extends Model
{
    protected $fillable = ['sasaran_id', 'sebab_risiko'];

    public function sasaran()
    {
        return $this->belongsTo(Sasaran::class);
    }

    public function perlakuanRisikos()
    {
        return $this->hasMany(PerlakuanRisiko::class);
    }
}
