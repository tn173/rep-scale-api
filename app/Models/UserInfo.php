<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'birthday',
        'height',
        'created_at',
        'updated_at',
    ];
}
