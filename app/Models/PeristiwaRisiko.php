<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeristiwaRisiko extends Model
{
    protected $fillable = ['taksonomi_id', 'nama', 'bobot'];

    public function taksonomi()
    {
        return $this->belongsTo(Taksonomi::class);
    }

    public function parameters()
    {
        return $this->hasMany(Parameter::class);
    }
}
