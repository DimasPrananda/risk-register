<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerlakuanRisiko extends Model
{
    protected $fillable = [
                        'sebab_risiko_id', 
                        'perlakuan_risiko',  
                        'dampak', 'probabilitas', 
                        'periode', 
                        'dokumen_pdf',
                        'output_target',
                        'output_realisasi',
                        'timeline_target',
                        'timeline_realisasi',
                        'biaya_target',
                        'biaya_realisasi'
                        ];

    public function sebabRisiko()
    {
        return $this->belongsTo(SebabRisiko::class, 'sebab_risiko_id');
    }

    public function sasaran()
    {
        return $this->belongsTo(Sasaran::class, 'sasaran_id');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'perlakuan_risiko_id');
    }
}
