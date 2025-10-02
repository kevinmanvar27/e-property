<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class City extends Model
{
    protected $table = 'city';

    protected $fillable = [
        'name',
        'districtid',
        'state_id',
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
        // Clear cache when a city is created, updated, or deleted
        static::saved(function ($city) {
            Cache::forget('cities_with_relations');
            Cache::forget('talukas_list_' . $city->districtid);
        });

        static::deleted(function ($city) {
            Cache::forget('cities_with_relations');
            Cache::forget('talukas_list_' . $city->districtid);
        });
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'districtid');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    // Alias for taluka
    public function taluka()
    {
        return $this->belongsTo(District::class, 'districtid');
    }
}