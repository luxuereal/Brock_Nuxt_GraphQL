<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GlAccount extends Model
{
    use HasFactory;

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
     * Get parent account for the child account.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get child account for the parent account.
     */
    public function child(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the gl type code that owns the gl account.
     */
    public function glTypeCode(): BelongsTo
    {
        return $this->belongsTo(GlTypeCode::class);
    }

    /**
     * The units that belong to the gl account.
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }
}
