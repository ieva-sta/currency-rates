<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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
     * @var array
     */
    protected $with = ['rates'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

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
        // @todo remove if unused
        $rates = $this->rates()->orderBy('date')->get();
        $latestRate = $rates->last()->price;

        $rates = $rates->slice(0, -1);
        $comparisonRate = $rates->last()->price;

        return $latestRate > $comparisonRate;
    }

    /**
     * @return Collection
     */
    public function getTrend(): Collection
    {
        $rates = $this->rates()->orderBy('date')->get();
        $latestRate = $rates->last()->price;

        $rates = $rates->slice(0, -1);
        $comparisonRate = $rates->last()->price;

        $percentage = (1 - $comparisonRate / $latestRate) * 100;
        $trend = $percentage > 0;

        return collect([
            'trend'      => $trend,
            'percentage' => number_format(abs($percentage), 2)
        ]);
    }
}
