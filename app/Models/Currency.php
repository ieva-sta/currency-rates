<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'title',
        'symbol'
    ];

    /**
     * @return HasMany
     */
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    /**
     * @return bool
     */
    public function getTrendAttribute(): bool
    {
        $rates = $this->rates()->orderBy('date')->get();
        $latestRate = $rates->last()->price;

        $rates = $rates->slice(0, -1);
        $comparisonRate = $rates->last()->price;

        return $latestRate > $comparisonRate;
    }
}
