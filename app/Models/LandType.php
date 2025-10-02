<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function landJamins()
    {
        return $this->belongsToMany(LandJamin::class, 'land_land_types', 'land_type_id', 'land_id');
    }
}
