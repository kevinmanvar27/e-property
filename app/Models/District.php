<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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