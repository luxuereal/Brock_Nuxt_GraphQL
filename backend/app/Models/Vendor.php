<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vendor extends Model
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
     * The terms that belongs to the vendor.
     */
    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(Term::class);
    }

    /**
     * The units that belong to the vendor.
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }
}
