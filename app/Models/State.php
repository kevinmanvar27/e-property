<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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