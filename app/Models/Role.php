<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    protected $fillable = ['name', 'description', 'status'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Clear cache when a role is created, updated, or deleted
        static::saved(function ($role) {
            Cache::forget('all_roles');
            Cache::forget('active_roles');
            Cache::forget('roles_list');
            Cache::forget('permissions_role_' . $role->id);
        });

        static::deleted(function ($role) {
            Cache::forget('all_roles');
            Cache::forget('active_roles');
            Cache::forget('roles_list');
            Cache::forget('permissions_role_' . $role->id);
        });
    }

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * The permissions that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    /**
     * Check if the role is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}