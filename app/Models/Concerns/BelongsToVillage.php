<?php

namespace App\Models\Concerns;

use App\Models\Village;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait BelongsToVillage
{
    protected static function bootBelongsToVillage(): void
    {
        static::addGlobalScope('village', function (Builder $builder) {
            $model = $builder->getModel();

            if (!Schema::hasColumn($model->getTable(), 'village_id')) {
                return;
            }

            if (app()->bound('currentVillageId')) {
                $builder->where($model->getTable() . '.village_id', app('currentVillageId'));
            }
        });

        static::creating(function ($model) {
            if (!Schema::hasColumn($model->getTable(), 'village_id')) {
                return;
            }

            if (!$model->village_id && app()->bound('currentVillageId')) {
                $model->village_id = app('currentVillageId');
            }
        });
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
