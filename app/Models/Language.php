<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
