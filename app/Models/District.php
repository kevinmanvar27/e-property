<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class District extends Model
{
    protected $table = 'district';
    protected $primaryKey = 'districtid';

    protected $fillable = [
        'district_title',
        'state_id',
        'district_description',
        'district_status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Clear cache when a district is created, updated, or deleted
        static::saved(function ($district) {
            Cache::forget('districts_with_relations');
            Cache::forget('districts_list_' . $district->state_id);
        });

        static::deleted(function ($district) {
            Cache::forget('districts_with_relations');
            Cache::forget('districts_list_' . $district->state_id);
        });
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'districtid');
    }

    public function talukas()
    {
        return $this->hasMany(City::class, 'districtid');
    }
}