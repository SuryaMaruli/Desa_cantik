<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorHit extends Model
{
    protected $fillable = [
        'visitor_uuid',
        'period_type',
        'period_key',
    ];
}
