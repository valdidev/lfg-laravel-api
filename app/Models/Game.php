<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'genre',
        'platform',
        'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
