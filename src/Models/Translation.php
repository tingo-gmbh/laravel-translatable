<?php

namespace Tingo\LaravelTranslatable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attribute',
        'value',
        'locale',
    ];

    /**
     * Get the owning translatable model.
     */
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }
}
