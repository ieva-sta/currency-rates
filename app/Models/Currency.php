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
        'title',
        'abbreviation'
    ];

    /**
     * @return HasMany
     */
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }
}
