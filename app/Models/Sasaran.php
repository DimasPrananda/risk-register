<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sasaran extends Model
{
    protected $fillable = ['periode_id', 'departemen_id', 'taksonomi_id', 'peristiwa_risiko_id', 'parameter_id', 'nama_sasaran', 'target', 'risiko', 'dampak', 'is_published', 'published_at'];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function sebabRisikos()
    {
        return $this->hasMany(SebabRisiko::class, 'sasaran_id');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function taksonomi()
    {
        return $this->belongsTo(Taksonomi::class);
    }

    public function peristiwaRisiko()
    {
        return $this->belongsTo(PeristiwaRisiko::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
