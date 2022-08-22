<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Period extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'period_end',
        'year',
        'month',
        'week',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'period_end',
    ];

    /**
     * The units that belong to the period.
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'unit_periods');
    }

    /**
     * Get the current period.
     */
    public static function currentPeriod()
    {   
        $currentDate = date('Y-m-d');

        return self::query()
            ->orderBy('period_end')
            ->firstWhere('period_end', '>=', $currentDate);
    }
    
    /**
     * Get next period
     */
    public function next()
    {
        return self::query()->
            where('id', '>', $this->id)
            ->orderBy('id','asc')
            ->first();
    }
    
    /**
     * Get previous period
     */
    public function previous()
    {
        return self::query()->
            where('id', '<', $this->id)
            ->orderBy('id','desc')
            ->first();
    }   
    
    public function scopeHasUnits($query, $hasUnits)
    {   
        if (!$hasUnits) {
            return;
        }
        
        $query->whereHas('units');
    }
}
