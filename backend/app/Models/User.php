<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\Contracts\HasApiTokens as HasApiTokensContract;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use App\Models\RoleMenu;
use Auth;

class User extends Authenticatable implements HasApiTokensContract, CanResetPasswordContract
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'is_admin',
        'is_active',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    /**
     * Determines if user is an administrator.
     * 
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->is_admin;
    }
    
    /**
     * Get the role that has the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    
    /**
     * The units that belong to the user.
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }

    /**
     * The selected unit.
     */
    public function selectedUnit() 
    {
        return $this->units()->wherePivot('selected', true)->first();
    }

    /**
     * The selected unit.
     */
    public function hasSelectedUnit() 
    {
        return !empty($this->selectedUnit());
    }

    /**
     * The active period.
     */
    public function activePeriod() 
    {
        return $this->selectedUnit()?->activePeriod();
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

}
