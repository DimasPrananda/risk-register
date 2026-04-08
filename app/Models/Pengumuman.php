<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $fillable = ['judul', 'file_pdf', 'periode_id'];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
