<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'official_name',
        'district',
        'city',
        'province',
        'postal_code',
        'address',
        'phone',
        'email',
        'map_query',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];
}
