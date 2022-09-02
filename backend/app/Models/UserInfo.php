<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'users';

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
        return $this->belongsToMany(Unit::class, 'unit_user', 'user_id', 'unit_id');
    }
}
