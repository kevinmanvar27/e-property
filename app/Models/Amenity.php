<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    
    public function landJamins()
    {
        return $this->belongsToMany(LandJamin::class, 'land_amenities', 'amenity_id', 'land_id');
    }
}