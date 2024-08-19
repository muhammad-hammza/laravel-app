<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'free_lancer_id', 'user_id', 'username', 'rating', 'comment'
    ];

    public function freeLancer()
    {
        return $this->belongsTo(FreeLancer::class, 'free_lancer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
