<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    use BelongsToVillage;

    protected $table = 'struktur_organisasis';

    protected $fillable = [
        'gambar',
    ];

    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return null;
    }
}
