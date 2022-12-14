<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoreUserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname',
        'age',
        'steam_account',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $table = 'more_users_info';
}
