<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = [
        'bulan_awal',
        'bulan_akhir',
    ];

    public function sasarans()
    {
        return $this->hasMany(Sasaran::class);
    }
}
