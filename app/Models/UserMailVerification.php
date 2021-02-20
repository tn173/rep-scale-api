<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMailVerification extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'tfa_token',
        'tfa_expires_at',
    ];
}
