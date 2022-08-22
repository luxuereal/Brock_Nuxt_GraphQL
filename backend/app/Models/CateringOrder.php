<?php

namespace App\Models;

use App\Traits\AttachPeriod;
use App\Traits\AttachUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CateringOrder extends Model
{
    use HasFactory, AttachUnit, AttachPeriod;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        
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
     * Get the items for the catering order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CateringOrderItem::class, 'catering_order_id');
    }

    /**
     * Get the unit owns the catering order.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function containItems(array $ids)
    {
        foreach ($ids as $id) {
            if (!$this->items->contains('id', $id)) {
                return false;
            }
        }

        return true;
    }
}
