<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHealthcare extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'steps',
        'created_at',
        'updated_at',
    ];
}
