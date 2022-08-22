<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\ClientException;
use App\Traits\Auth\ManagesAuth;

trait AttachUnit
{
    use ManagesAuth;

    /**
     * Boot the trait.
     * 
     * @return void
     */
    public static function bootAttachUnit()
    {
        static::saving(function ($model) {
            $user = static::authenticatedUser();

            $selectedUnit = $user->selectedUnit();

            if(!$selectedUnit) {
                throw new ClientException(
                    message: "The unit must be selected by the user."
                );
            }

            if($model->isRelation('unit')) {
                $model->unit()->associate($selectedUnit);
            }
        });
    }
}