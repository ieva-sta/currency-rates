<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rate extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'currency_id',
        'price',
        'date'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'date' => 'datetime:d.m.Y H:i:s'
    ];

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
