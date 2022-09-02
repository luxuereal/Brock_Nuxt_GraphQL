<?php

namespace App\Policies;

use App\Enums\OperatingType;
use App\Models\UnitByPeriod;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitByPeriodPolicy
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
     * @param  \App\Models\UnitByPeriod  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UnitByPeriod $unit)
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
     * @param  \App\Models\UnitByPeriod  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UnitByPeriod $unit)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UnitByPeriod  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UnitByPeriod $unit)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UnitByPeriod  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UnitByPeriod $unit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UnitByPeriod  $unit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UnitByPeriod $unit)
    {
        //
    }
}
