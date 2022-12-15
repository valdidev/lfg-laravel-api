<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'party_user');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
