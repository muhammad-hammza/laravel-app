<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\reviews;

class freeLancer extends Model
{
    use HasFactory;
    public function reviews()
    {
        return $this->hasMany(reviews::class, 'free_lancer_id');
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

}
