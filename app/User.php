<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /*\*
     \* The attributes that are mass assignable.
     \*
     \* @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'affiliate_id', 'referred_by','first_name', 'last_name', 'city', 'state', 'country', 'image', 'usertype'
    ];

    /*\*
     \* The attributes that should be hidden for arrays.
     \*
     \* @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
