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
        'year',
        'parent_key',
        'label',
        'value',
    ];

    protected $casts = [
        'year' => 'integer',
        'value' => 'decimal:2',
    ];
}
