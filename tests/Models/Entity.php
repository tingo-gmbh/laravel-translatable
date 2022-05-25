<?php

namespace Tingo\LaravelTranslatable\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tingo\LaravelTranslatable\Tests\Factories\EntityFactory;
use Tingo\LaravelTranslatable\Translatable;

class Entity extends Model
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'unit',
        'price',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array<string>
     */
    protected array $translatable = [
        'name',
        'category',
        'description',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return EntityFactory::new();
    }
}