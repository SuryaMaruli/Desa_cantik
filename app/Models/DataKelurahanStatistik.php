<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;
use Illuminate\Database\Eloquent\Model;

class DataKelurahanStatistik extends Model
{
    use BelongsToVillage;

    protected $table = 'data_kelurahan_statistiks';

    protected $fillable = [
        'village_id',
        'subject_key',
        'dataset_key',
        'parent_key',
        'label',
        'value',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];
}
