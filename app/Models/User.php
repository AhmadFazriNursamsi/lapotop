<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function divisions()
    {
        return $this->belongsTo('App\Models\Division','id_division', 'id_division');
    }

    public function roles()
    {
        return $this->belongsTo('App\Models\Role','id_role', 'id_role');
    }

    public function uaccess()
    {
        return $this->hasMany('App\Models\Useraccess','id_users', 'id');
    }
    public function customers()
    {
        return $this->hasMany('App\Models\Customers','id', 'id');
    }
}
