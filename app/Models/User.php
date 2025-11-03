<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use App\Notifications\CustomVerifyEmail;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $username
 * @property string $email
 * @property string|null $contact
 * @property string|null $photo
 * @property string|null $dob
 * @property string $password
 * @property string|null $role
 * @property int|null $role_id
 * @property string $status
 * @property string|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method PersonalAccessToken createToken(string $name, array $abilities = ['*'])
 * @method \Illuminate\Support\Collection tokens()
 * @method \Illuminate\Support\Collection currentAccessToken()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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
        'role_id',
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Clear cache when a user is created, updated, or deleted
        static::saved(function ($user) {
            Cache::forget('active_users_count');
            Cache::forget('users_with_roles');
            Cache::forget('user_' . $user->id);
        });

        static::deleted(function ($user) {
            Cache::forget('active_users_count');
            Cache::forget('users_with_roles');
            Cache::forget('user_' . $user->id);
        });
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
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
        if (! $this->password_changed_at) {
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

    /**
     * Check if the user has a specific permission
     *
     * @param string $module
     * @param string $action
     * @return bool
     */
    public function hasPermission($module, $action)
    {
        // Super admins have all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Check if user has specific permission
        return $this->permissions()->where('module', $module)->where('action', $action)->exists() ||
               ($this->role && $this->role instanceof Role && $this->role->permissions()->where('module', $module)->where('action', $action)->exists());
    }

    /**
     * Get user permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    /**
     * Get the user's wishlist items
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the properties wishlisted by the user
     */
    public function wishlistedProperties()
    {
        return $this->belongsToMany(Property::class, 'wishlists', 'user_id', 'property_id');
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}