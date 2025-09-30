<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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