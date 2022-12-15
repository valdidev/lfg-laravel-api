<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory;

  protected $fillable = [
    'message',
    'user_id',
    'party_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function party()
  {
    return $this->belongsTo(Party::class);
  }
}
