<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chapter extends Model
{
    use HasFactory;

    //RELATIONS

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
