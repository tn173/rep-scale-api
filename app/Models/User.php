<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'mail',
        'password',
        'created_at',
        'updated_at',
    ];

    public function info(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }

    public function measurement(): HasOne
    {
        return $this->hasOne(UserMeasurement::class);
    }

}
