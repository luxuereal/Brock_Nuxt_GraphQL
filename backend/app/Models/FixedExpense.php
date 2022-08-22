<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AttachUnit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Unit;
use App\Models\GlAccount;

class FixedExpense extends Model
{
    use HasFactory, AttachUnit;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'monthly', 'gl_account_id', 'amount', 'comments', 'unit_id'
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
     * Get the unit owns the fixed expense.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    
    /**
     * Get the gl account that owns the fixed expense.
     */
    public function glAccount(): BelongsTo
    {
        return $this->belongsTo(GlAccount::class);
    }
}
