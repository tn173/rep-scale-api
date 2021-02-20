<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAuthentication extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'device_identifier',
        'access_token',
        'access_token_expires_at',
        'refresh_token',
        'refresh_token_expires_at',
    ];
}
