<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cv12 extends Model
{
    use HasFactory;
    protected $casts = [
        'profile_image' => 'array',
        'profile_name' => 'array',
        'profile_description' => 'array',
        'education_scholl' => 'array',
        'education_city' => 'array',
        'education_start_date' => 'array',
        'education_end_date' => 'array',
        'education_description' => 'array',
        'address' => 'array',
        'phone' => 'array',
        'email' => 'array',
        'skills' => 'array',
        'language' => 'array',
        'leveleOf_language' => 'array',
        'course_title' => 'array',
        'course_year' => 'array',
        'course_description' => 'array',
        'experiencetitle' => 'array',
        'experience_year' => 'array',
        'experience_description' => 'array',


    ];
}