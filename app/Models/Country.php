<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Country extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'country_id';

    protected $fillable = [
        'country_name',
        'country_code',
        'description',
        'status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Clear cache when a country is created, updated, or deleted
        static::saved(function ($country) {
            Cache::forget('all_countries');
        });

        static::deleted(function ($country) {
            Cache::forget('all_countries');
        });
    }

    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }
}