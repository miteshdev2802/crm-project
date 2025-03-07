<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'profile_image',
        'additional_file',
        'custom_fields',
    ];

    protected $casts = [
        'custom_fields' => 'array',
    ];
}
