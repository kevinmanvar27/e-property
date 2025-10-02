<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class State extends Model
{
    protected $table = 'state';
    protected $primaryKey = 'state_id';

    protected $fillable = [
        'state_title',
        'state_description',
        'country_id',
        'status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Clear cache when a state is created, updated, or deleted
        static::saved(function ($state) {
            Cache::forget('states_with_countries');
            Cache::forget('states_list');
            Cache::forget('states_list_country_' . $state->country_id);
        });

        static::deleted(function ($state) {
            Cache::forget('states_with_countries');
            Cache::forget('states_list');
            Cache::forget('states_list_country_' . $state->country_id);
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'state_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id');
    }
}