<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\ClientException;
use App\Models\Period;
use App\Models\Unit;
use App\Traits\Auth\ManagesAuth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AttachPeriod
{
    use ManagesAuth;

    /**
     * Boot the trait.
     * 
     * @return void
     */
    public static function bootAttachPeriod()
    {
        static::created(function ($model) {
            if ($model instanceof Unit) {
                if($model->isRelation('periods')) {
                    $model->periods()->attach($model->startPeriod);
                }
            }
        });
        
        static::saving(function ($model) {
            if (!$model instanceof Unit) {
                $user = static::authenticatedUser();

                $selectedUnit = $user->selectedUnit();

                $activePeriod = $selectedUnit->activePeriod();

                if(!$selectedUnit) {
                    throw new ClientException(
                        message: "The unit must be selected by the user."
                    );
                }

                if($model->isRelation('period') && $activePeriod) {
                    $model->period()->associate($activePeriod);
                }
            }
        });
    }

    public function scopeActivePeriod($query, $activePeriod)
    {   
        if (!$activePeriod) {
            return;
        }

        $period = static::authenticatedUser()->activePeriod()?->id;

        $query->whereHas('period', function (Builder $query) use ($period) {
            $query->where('period_id', $period);
        });
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }
}