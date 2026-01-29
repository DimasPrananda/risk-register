<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerlakuanRisiko extends Model
{
    protected $fillable = ['sebab_risiko_id', 'perlakuan_risiko', 'dampak', 'probabilitas', 'periode', 'dokumen_pdf'];

    public function sebabRisiko()
    {
        return $this->belongsTo(SebabRisiko::class);
    }
}
