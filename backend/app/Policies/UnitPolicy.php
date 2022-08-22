<?php

namespace App\Policies;

use App\Enums\OperatingType;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {   
        //
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Unit $unit)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Unit $unit)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Unit $unit)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Unit $unit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Unit $unit)
    {
        //
    }

    /**
     * Determine whether the user can select the unit.
     *
     * @param  \App\Models\User  $user
     * @param  array  $injectedArgs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function selectUnit(User $user, array $injectedArgs)
    {   
        if ($user->isAdministrator()) {
            return false;
        }
        
        $hasUnit = $user->units->contains($injectedArgs['id']);

        if ($hasUnit) {
            return true;
        }
    }

    /**
     * Determine whether the user can generate operating report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @param  \App\Enums\OperatingType $type
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function generateOperatingReport(User $user, Unit $unit, OperatingType $type)
    {
        if (!$user->isAdministrator()) {
            $hasUnit = $user->units->contains($unit->id);

            if ($hasUnit) {
                return false;
            }
        } else {
            return true;
        }
    }
}
