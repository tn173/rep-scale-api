<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMeasurement extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'date',
        'impedance',
        'weight',
        'BMI',
        'body_fat_percentage',
        'muscle_kg',
        'water_percentage',
        'VFAL',
        'bone_kg',
        'BMR',
        'protein_percentage',
        'VF_percentage',
        'lose_fat_weight_kg',
        'body_standard',
    ];
}

