<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public const AVATARS_DEFAULT_DISK = "avatars";

    public const ROLES = [
        "admin" => "ROLE_ADMIN",
        "superAdmin" => "ROLE_SUPER_ADMIN"
    ];

    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'patronymic_name',
        'email',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->role ? in_array($this->role->name, self::ROLES) && $this->role->name === self::ROLES['admin'] : false;
    }

//todo move to general enum
    public function isSuperAdmin(): bool
    {
        return $this->role ? in_array($this->role->name, self::ROLES) && $this->role->name === self::ROLES['superAdmin'] : false;
    }

    public function grantedAdminRoles(): bool
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
