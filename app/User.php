<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use Storage;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'is_active', 'last_login', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getPhotoAttribute($value)
    {
        if ($value == null) {
            return asset('images/male.png');
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset('images/male.png');
        } else {
            return asset(Storage::url($value));
        }
    }

    public function getRole()
    {
        return $this->roles()->first()->name;
    }

    public function getRoleName()
    {
        return $this->roles()->first()->display_name;
    }
}
