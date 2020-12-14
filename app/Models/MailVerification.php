<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailVerification extends Model
{
    protected $fillable = [
        'mail',
        'password',
        'tfa_token',
        'tfa_expiration',
    ];
}
