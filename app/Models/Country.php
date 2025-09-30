<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    
    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }
}