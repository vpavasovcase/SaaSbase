<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'remember_token',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class);
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
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
