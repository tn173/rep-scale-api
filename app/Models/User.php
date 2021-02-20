<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'gender',
        'birthday',
        'heigt',
        'mail',
        'password',
    ];

    public function authentications(): HasMany
    {
        return $this->hasMany(\App\Models\UserAuthentication::class);
    }

    public function mailVerifications(): HasMany
    {
        return $this->hasMany(\App\Models\UserMailVerification::class);
    }

    public function measurements(): HasMany
    {
        return $this->hasMany(\App\Models\UserMeasurement::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(\App\Models\UserStep::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->authentications()->delete();
            $user->mailVerifications()->delete();
            $user->measurements()->delete();
            $user->steps()->delete();
        });
    }

}
