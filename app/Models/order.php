<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'payment_id', 'qr_code', 'personal_app_link', 'business_app_link', 'status','plan_type',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
