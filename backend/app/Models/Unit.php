<?php

namespace App\Models;

use App\Traits\AttachPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory, AttachPeriod;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active'               => 'boolean',
        'is_vending'              => 'boolean',
        'is_kronos'               => 'boolean',
    ];

    /**
     * Get the district that owns the unit.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the county that owns the unit.
     */
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    /**
     * Get the city that owns the unit.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the start period of the unit.
     */
    public function startPeriod(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'start_period');
    }
    
    /**
     * Get the unit type owns the unit.
     */
    public function unitType(): BelongsTo
    {
        return $this->belongsTo(UnitType::class);
    }

    /**
     * The users that belong to the unit.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The vendors that belong to the unit.
     */
    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class)->orderBy('vendors.name');
    }

    /**
     * The gl accounts that belong to the unit.
     */
    public function glAccounts(): BelongsToMany
    {
        return $this->belongsToMany(GlAccount::class);
    }

    /**
     * The periods that belong to the unit.
     */
    public function periods(): BelongsToMany
    {
        return $this->belongsToMany(Period::class, 'unit_periods')
            ->withPivot('is_closed')
            ->orderBy('period_end', 'desc');
    }

    /**
     * Get the regTax that owns the unit.
     */
    public function regTax(): BelongsTo
    {
        return $this->belongsTo(GlAccount::class, 'reg_tax_id');
    }

    /**
     * The active period.
     */
    public function activePeriod()
    {
        return $this->periods()->firstWhere('is_closed', false);
    }

    /**
     * The inventories that belong to the unit.
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}
