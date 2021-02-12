<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = [
        'gender',
        'birthday',
        'heigt',
        'mail',
        'password',
        'api_token',
    ];

    public function measurement(): HasMany
    {
        return $this->hasMany(UserMeasurement::class);
    }

    public function healthcare(): HasMany
    {
        return $this->hasMany(UserHealthcare::class);
    }

}
