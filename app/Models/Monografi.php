<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monografi extends Model
{
    protected $table = 'monografis';
    
    protected $primaryKey = 'id_monografi';

protected $fillable = [
        'gambar_mono',
    ];

    public function getGambarMonoUrlAttribute()
    {
        if ($this->gambar_mono) {
            return asset('storage/' . $this->gambar_mono);
        }
        return null;
    }
}
