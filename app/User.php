<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Eloquent implements AuthenticatableContract {

    use Authenticatable;
    use Notifiable;

    protected $collection = 'admin';

    protected $fillable = [
        'user', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
