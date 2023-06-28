<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function getAdmin(): ?Role
    {
        return Role::where('name', 'ROLE_ADMIN')->first();
    }

    public static function getSuperAdmin(): ?Role
    {
        return Role::where('name', 'ROLE_SUPER_ADMIN')->first();
    }
}
