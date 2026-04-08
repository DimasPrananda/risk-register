<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $fillable = ['peristiwa_risiko_id', 'nama', 'bobot'];
    
    public function peristiwaRisiko()
    {
        return $this->belongsTo(PeristiwaRisiko::class);
    }
}
