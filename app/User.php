<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = [
        'name'
    ];

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
    ];

    public function createdBy() {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updatedBy() {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
    
    public function accessLevelId() {
        return $this->hasOne('App\AccessLevel', 'id', 'access_level_id');
    }

    public function getNameAttribute() {
        return $this->first_name .' '. $this->last_name .' '. $this->extension;
    }
}
