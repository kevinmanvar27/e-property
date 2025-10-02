<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Permission extends Model
{
    protected $fillable = ['name', 'module', 'action'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Clear cache when a permission is created, updated, or deleted
        static::saved(function ($permission) {
            Cache::forget('all_permissions');
            Cache::forget('permissions_list');
        });

        static::deleted(function ($permission) {
            Cache::forget('all_permissions');
            Cache::forget('permissions_list');
        });
    }

    /**
     * The users that belong to the permission.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions', 'permission_id', 'user_id');
    }

    /**
     * The roles that belong to the permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }
}