<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

        //RELATIONS

        public function roles()
        {
            return $this->belongsToMany(Role::class);
        }
    
        public function companies()
        {
            return $this->hasManyThrough(Company::class, Chapter::class);
        }
    
        //MUTATORS
    
        public function getPhoneAttribute($value)
        {
            return Crypt::decryptString($value);
        }
        public function setPhoneAttribute($value)
        {
            $this->attributes['phone'] = Crypt::encryptString($value);
        }

}