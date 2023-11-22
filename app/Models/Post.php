<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // protected $fillable = ['user_id', 'title', 'body'];
    protected $fillable = ['title', 'body'];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function ownerBy(User $user)
    {
        return $user->id === $this->user_id;
    }
}
