<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;
use Illuminate\Database\Eloquent\Model;

class VillageSetting extends Model
{
    use BelongsToVillage;

    protected $fillable = [
        'village_id',
        'key',
        'value',
    ];
}