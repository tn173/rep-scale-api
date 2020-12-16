<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = [
        'mail',
        'password',
        'api_token',
    ];

    // protected $hidden = [
    //     'password', 'api_token',
    // ];

    public function info(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }

    public function measurement(): HasMany
    {
        return $this->hasMany(UserMeasurement::class);
    }

    public function healthcare(): HasMany
    {
        return $this->hasMany(UserHealthcare::class);
    }

}
