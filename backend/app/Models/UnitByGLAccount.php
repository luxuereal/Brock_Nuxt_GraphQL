<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UnitByGLAccount extends Model
{
    use HasFactory;

    protected $table = 'units';

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
     * The gl accounts that belong to the unit.
     */
    public function glAccounts(): BelongsToMany
    {
        return $this->belongsToMany(GlAccount::class, 'gl_account_unit', 'unit_id', 'gl_account_id');
    }
}
