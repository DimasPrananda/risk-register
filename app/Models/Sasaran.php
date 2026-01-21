<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sasaran extends Model
{
    protected $fillable = ['periode_id', 'departemen_id', 'nama_sasaran', 'target', 'risiko', 'dampak'];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function sebabRisikos()
    {
        return $this->hasMany(SebabRisiko::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
}
