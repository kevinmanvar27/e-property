<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'contact',
        'photo',
        'dob',
        'role',
        'status',
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_login_at',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date',
        ];
    }
    
    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin' || $this->role === 'super_admin';
    }
    
    /**
     * Check if the user is a super admin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
    
    /**
     * Check if the user is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
    
    /**
     * Record user login
     *
     * @return void
     */
    public function recordLogin()
    {
        $this->last_login_at = now();
        $this->save();
    }
    
    /**
     * Check if password has been changed recently
     *
     * @param int $days
     * @return bool
     */
    public function passwordChangedWithin($days = 90)
    {
        if (!$this->password_changed_at) {
            return false;
        }
        
        return $this->password_changed_at->greaterThan(now()->subDays($days));
    }
    
    /**
     * Mark password as changed
     *
     * @return void
     */
    public function markPasswordAsChanged()
    {
        $this->password_changed_at = now();
        $this->save();
    }
}