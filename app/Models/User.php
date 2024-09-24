<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements AuthenticatableContract
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
