<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class EmailExists implements Rule
{
    public function passes($attribute, $value)
    {
        return User::where('email', $value)->exists();
    }

    public function message()
    {
        return 'Email not found.';
    }
}
