<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class MaklumatPelayananan extends Model
{
    use BelongsToVillage;

    protected $table = 'maklumat_pelayananans';

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
