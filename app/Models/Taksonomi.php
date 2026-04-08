<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taksonomi extends Model
{
    protected $fillable = ['nama', 'bobot'];

    public function peristiwaRisikos()
    {
        return $this->hasMany(PeristiwaRisiko::class);
    }
}
