<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_enabled'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function party()
    {
        return $this->belongsToMany(Party::class);
    }

    public function moreInfo()
    {
        return $this->hasOne(MoreUserInfo::class);
    }
}
