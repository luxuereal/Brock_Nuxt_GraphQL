<?php

namespace App\Models;

use App\Traits\Auth\ManagesAuth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryCategory extends Model
{
    use HasFactory, ManagesAuth;

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
        
    ];

    /**
     * Get the gl account owns the inventory category.
     */
    public function glAccount(): BelongsTo
    {
        return $this->belongsTo(GlAccount::class);
    }

    /**
     * Get the inventories for the category.
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Get the inventory amount.
     */
    public function inventoryAmount($unitId, $periodId)
    {   
        return $this->inventories()->where('unit_id', $unitId)
            ->where('period_id', $periodId)
            ->first()?->amount;
    }
}
