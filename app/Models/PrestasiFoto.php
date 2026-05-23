<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestasiFoto extends Model
{
    protected $fillable = [
        'prestasi_id',
        'foto',
        'position',
    ];

    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class);
    }
}
