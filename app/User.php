<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function getFriends()
    {
        $collection = $this->belongsToMany(
            'App\User',
            'friends',
            'user0_id',
            'user1_id'
        )->get();
        $collection = $collection->merge($this->belongsToMany(
            'App\User',
            'friends',
            'user1_id',
            'user0_id'
        )->get());
        return $collection;
    }
}
